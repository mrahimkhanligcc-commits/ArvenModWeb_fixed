<?php

require_once BASE_PATH . '/app/Core/Database.php';

class CartController
{
    public function __construct()
    {
        $this->startSession();

        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index(): void
    {
        $db = new Database();
        $cartItems = [];
        $cartTotal = 0.0;

        if ($_SESSION['cart']) {
            $ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $stmt = $db->pdo->prepare(
                "SELECT product_id, name, price, image, stock
                 FROM products
                 WHERE product_id IN ($placeholders)"
            );
            $stmt->execute($ids);

            foreach ($stmt->fetchAll() as $product) {
                $id = (int)$product['product_id'];
                $quantity = max(1, (int)($_SESSION['cart'][$id] ?? 1));

                // Do not allow more items than are currently in stock.
                $quantity = min($quantity, max(0, (int)$product['stock']));

                if ($quantity === 0) {
                    unset($_SESSION['cart'][$id]);
                    continue;
                }

                $product['quantity'] = $quantity;
                $product['total'] = $quantity * (float)$product['price'];

                $cartItems[] = $product;
                $cartTotal += $product['total'];
            }
        }

        $title = 'Your Cart - Arven Online Shop';

        $view = BASE_PATH . '/app/Views/cart.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function add(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            die('Product ID is required.');
        }

        $db = new Database();
        $stmt = $db->pdo->prepare("SELECT stock FROM products WHERE product_id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            http_response_code(404);
            die('Product not found.');
        }

        $stock = (int)$product['stock'];

        if ($stock < 1) {
            header('Location: /products');
            exit;
        }

        $current = (int)($_SESSION['cart'][$id] ?? 0);

        if ($current < $stock) {
            $_SESSION['cart'][$id] = $current + 1;
        }

        header('Location: /cart');
        exit;
    }

    public function remove(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            unset($_SESSION['cart'][$id]);
        }

        header('Location: /cart');
        exit;
    }

    public function clear(): void
    {
        $_SESSION['cart'] = [];
        header('Location: /cart');
        exit;
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
