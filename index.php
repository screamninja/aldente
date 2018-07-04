<?php

require_once 'vendor/autoload.php'; // Автозагрузка классов через Composer

session_start();

// echo 'Hello, World!';

try {
    $router = new PFW\Core\Router();
    $router->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}
