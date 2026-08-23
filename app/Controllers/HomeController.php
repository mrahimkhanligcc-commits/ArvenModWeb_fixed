<?php

require_once BASE_PATH . '/app/Core/Database.php';

class HomeController
{
    public function index(): void
    {
        $db = new Database();

        $stmt = $db->pdo->query(
            "SELECT product_id, name, price, image, stock, description
             FROM products
             ORDER BY product_id DESC
             LIMIT 4"
        );

        $featured = $stmt->fetchAll();
        $title = 'Arven Online Shop';

        $view = BASE_PATH . '/app/Views/Home.php';
        require BASE_PATH . '/app/Views/layout.php';
    }
}
