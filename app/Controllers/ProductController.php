<?php

require_once BASE_PATH . '/app/Core/Database.php';

class ProductController
{
    public function show(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            die('Product ID is required.');
        }

        $db = new Database();

        $stmt = $db->pdo->prepare(
            "SELECT product_id, name, price, image, stock, description
             FROM products
             WHERE product_id = ?"
        );

        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            http_response_code(404);
            die('Product not found.');
        }

        $title = $product['name'] . ' - Arven Online Shop';

        $view = BASE_PATH . '/app/Views/product.php';
        require BASE_PATH . '/app/Views/layout.php';
    }
}
