<?php

require_once BASE_PATH . '/app/Core/Database.php';

class AdminController
{
    private Database $db;

    public function __construct()
    {
        $this->startSession();

        if (empty($_SESSION['auth']['logged_in']) ||
            ($_SESSION['auth']['role'] ?? '') !== 'admin') {
            header('Location: /login');
            exit;
        }

        $this->db = new Database();
    }

    public function index(): void
    {
        $title = 'Admin Dashboard - Arven Online Shop';
        $view = BASE_PATH . '/app/Views/admin/dashboard.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function orders(): void
    {
        $stmt = $this->db->pdo->query(
            "SELECT o.*, c.name AS customer_name
             FROM orders o
             JOIN customers c ON o.customer_id = c.customer_id
             ORDER BY o.order_id DESC"
        );

        $orders = $stmt->fetchAll();
        $title = 'Orders - Arven Admin';

        $view = BASE_PATH . '/app/Views/admin/orders.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function orderDetails(): void
    {
        $orderId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$orderId) {
            http_response_code(400);
            die('Order ID is required.');
        }

        $stmt = $this->db->pdo->prepare(
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

        $stmt = $this->db->pdo->prepare(
            "SELECT oi.*, p.name
             FROM order_items oi
             JOIN products p ON oi.product_id = p.product_id
             WHERE oi.order_id = ?"
        );
        $stmt->execute([$orderId]);
        $items = $stmt->fetchAll();

        $title = 'Order Details - Arven Admin';
        $view = BASE_PATH . '/app/Views/admin/order-details.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function products(): void
    {
        $stmt = $this->db->pdo->query(
            "SELECT * FROM products ORDER BY product_id DESC"
        );

        $products = $stmt->fetchAll();
        $title = 'Manage Products - Arven Admin';

        $view = BASE_PATH . '/app/Views/admin/products.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function addProduct(): void
    {
        $title = 'Add Product - Arven Admin';
        $view = BASE_PATH . '/app/Views/admin/add-product.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function saveProduct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Invalid request.');
        }

        $name = trim($_POST['name'] ?? '');
        $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
        $size = $_POST['size'] ?? 'M';
        $image = trim($_POST['image'] ?? '');
        $stock = filter_var($_POST['stock'] ?? '', FILTER_VALIDATE_INT);
        $description = trim($_POST['description'] ?? '');

        $allowedSizes = ['S', 'M', 'L', 'XL', 'XXL'];

        if (
            $name === '' ||
            $price === false || $price < 0 ||
            !in_array($size, $allowedSizes, true) ||
            $stock === false || $stock < 0 ||
            $description === ''
        ) {
            http_response_code(422);
            die('Please enter valid product information.');
        }

        $stmt = $this->db->pdo->prepare(
            "INSERT INTO products
             (name, price, size, image, stock, description)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $name,
            $price,
            $size,
            $image ?: 'product-placeholder.svg',
            $stock,
            $description
        ]);

        header('Location: /admin/products');
        exit;
    }

    public function deleteProduct(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            die('Product ID is required.');
        }

        $stmt = $this->db->pdo->prepare(
            "DELETE FROM products WHERE product_id = ?"
        );
        $stmt->execute([$id]);

        header('Location: /admin/products');
        exit;
    }

    public function customers(): void
    {
        $stmt = $this->db->pdo->query(
            "SELECT customer_id, name, email, address, created_at
             FROM customers
             ORDER BY customer_id DESC"
        );

        $customers = $stmt->fetchAll();
        $title = 'Customers - Arven Admin';

        $view = BASE_PATH . '/app/Views/admin/customers.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
