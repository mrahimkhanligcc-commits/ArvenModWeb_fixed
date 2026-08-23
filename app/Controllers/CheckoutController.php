<?php

require_once BASE_PATH . '/app/Core/Database.php';

class CheckoutController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index(): void
    {
        if (empty($_SESSION['cart'])) {
            header('Location: /products');
            exit;
        }

        $title = 'Checkout - Arven Online Shop';
        $view = BASE_PATH . '/app/Views/checkout.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Invalid request.');
        }

        if (empty($_SESSION['cart'])) {
            header('Location: /products');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if ($name === '' || $address === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            die('Please provide a valid name, email address and delivery address.');
        }

        $db = new Database();

        try {
            $db->pdo->beginTransaction();

            // Get the current products and prices from the database.
            $ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $stmt = $db->pdo->prepare(
                "SELECT product_id, price, stock
                 FROM products
                 WHERE product_id IN ($placeholders)
                 FOR UPDATE"
            );
            $stmt->execute($ids);
            $products = $stmt->fetchAll();

            $productMap = [];
            foreach ($products as $product) {
                $productMap[(int)$product['product_id']] = $product;
            }

            $total = 0.0;

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $productId = (int)$productId;
                $quantity = (int)$quantity;

                if (!isset($productMap[$productId])) {
                    throw new RuntimeException('A product in your cart no longer exists.');
                }

                if ($quantity < 1 || $quantity > (int)$productMap[$productId]['stock']) {
                    throw new RuntimeException('There is not enough stock for one of the products.');
                }

                $total += (float)$productMap[$productId]['price'] * $quantity;
            }

            // Customer
            $stmt = $db->pdo->prepare(
                "INSERT INTO customers (name, email, address)
                 VALUES (?, ?, ?)"
            );
            $stmt->execute([$name, $email, $address]);
            $customerId = (int)$db->pdo->lastInsertId();

            // Order
            $stmt = $db->pdo->prepare(
                "INSERT INTO orders (customer_id, total_amount, order_date)
                 VALUES (?, ?, NOW())"
            );
            $stmt->execute([$customerId, $total]);
            $orderId = (int)$db->pdo->lastInsertId();

            // Order items + reduce stock
            $itemStmt = $db->pdo->prepare(
                "INSERT INTO order_items
                 (order_id, product_id, quantity, price_at_purchase)
                 VALUES (?, ?, ?, ?)"
            );

            $stockStmt = $db->pdo->prepare(
                "UPDATE products
                 SET stock = stock - ?
                 WHERE product_id = ?"
            );

            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $productId = (int)$productId;
                $quantity = (int)$quantity;
                $price = (float)$productMap[$productId]['price'];

                $itemStmt->execute([$orderId, $productId, $quantity, $price]);
                $stockStmt->execute([$quantity, $productId]);
            }

            $db->pdo->commit();

            $_SESSION['cart'] = [];

            header('Location: /order-success?id=' . $orderId);
            exit;

        } catch (Throwable $e) {
            if ($db->pdo->inTransaction()) {
                $db->pdo->rollBack();
            }

            http_response_code(500);
            die('Unable to place the order. Please try again.');
        }
    }

    public function success(): void
    {
        $orderId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$orderId) {
            http_response_code(400);
            die('Order ID is required.');
        }

        $db = new Database();

        $stmt = $db->pdo->prepare(
            "SELECT o.*, c.name, c.email, c.address
             FROM orders o
             JOIN customers c ON o.customer_id = c.customer_id
             WHERE o.order_id = ?"
        );
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        if (!$order) {
            http_response_code(404);
            die('Order not found.');
        }

        $stmt = $db->pdo->prepare(
            "SELECT oi.*, p.name
             FROM order_items oi
             JOIN products p ON oi.product_id = p.product_id
             WHERE oi.order_id = ?"
        );
        $stmt->execute([$orderId]);
        $items = $stmt->fetchAll();

        $title = 'Order Successful - Arven Online Shop';
        $view = BASE_PATH . '/app/Views/order-success.php';
        require BASE_PATH . '/app/Views/layout.php';
    }
}
