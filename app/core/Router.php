<?php

// The Router decides which controller should handle the request
// based on the URL path.

class Router
{
    public function dispatch(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        // When using: php -S localhost:8000 -t public
        // the base path is normally empty. This also supports
        // running the project from an XAMPP sub-folder.
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

        if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        $path = $path === '' ? '/' : '/' . ltrim($path, '/');

        switch ($path) {

            case '/':
                $this->run('HomeController', 'index');
                break;

            case '/products':
                $this->run('ProductsController', 'index');
                break;

            case '/product':
                $this->run('ProductController', 'show');
                break;

            case '/cart':
                $this->run('CartController', 'index');
                break;

            case '/cart/add':
                $this->run('CartController', 'add');
                break;

            case '/cart/remove':
                $this->run('CartController', 'remove');
                break;

            case '/cart/clear':
                $this->run('CartController', 'clear');
                break;

            case '/checkout':
                $this->run('CheckoutController', 'index');
                break;

            case '/checkout/submit':
                $this->run('CheckoutController', 'submit');
                break;

            case '/order-success':
                $this->run('CheckoutController', 'success');
                break;

            case '/login':
                $this->run('AuthController', 'login');
                break;

            case '/register':
                $this->run('AuthController', 'register');
                break;

            case '/logout':
                $this->run('AuthController', 'logout');
                break;

            // Admin
            case '/admin':
                $this->run('AdminController', 'index');
                break;

            case '/admin/orders':
                $this->run('AdminController', 'orders');
                break;

            case '/admin/order-details':
                $this->run('AdminController', 'orderDetails');
                break;

            case '/admin/products':
                $this->run('AdminController', 'products');
                break;

            case '/admin/add-product':
                $this->run('AdminController', 'addProduct');
                break;

            case '/admin/save-product':
                $this->run('AdminController', 'saveProduct');
                break;

            case '/admin/delete-product':
                $this->run('AdminController', 'deleteProduct');
                break;

            case '/admin/customers':
                $this->run('AdminController', 'customers');
                break;

            default:
                $this->notFound();
                break;
        }
    }

    private function run(string $controller, string $method): void
    {
        $controllerFile = BASE_PATH . "/app/Controllers/{$controller}.php";

        if (!file_exists($controllerFile)) {
            http_response_code(500);
            die("Controller file not found: {$controllerFile}");
        }

        require_once $controllerFile;

        if (!class_exists($controller)) {
            http_response_code(500);
            die("Controller class not found: {$controller}");
        }

        $instance = new $controller();

        if (!method_exists($instance, $method)) {
            http_response_code(500);
            die("Method {$method} not found in {$controller}");
        }

        $instance->$method();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
        echo '<p><a href="/">Return to Arven Online Shop</a></p>';
    }
}
