<?php

require_once BASE_PATH . '/app/Core/Database.php';

class ProductsController
{
    public function index(): void
    {
        $db = new Database();

        $stmt = $db->pdo->query(
            "SELECT product_id, name, price, image, stock, description
             FROM products
             ORDER BY product_id DESC"
        );

        $products = $stmt->fetchAll();
        $title = 'Products - Arven Online Shop';

        $view = BASE_PATH . '/app/Views/products.php';
        require BASE_PATH . '/app/Views/layout.php';
    }
}
