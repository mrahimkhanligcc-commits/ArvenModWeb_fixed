<?php

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/Core/Router.php';

$router = new Router();
$router->dispatch();
