<?php

require_once 'vendor/autoload.php';

session_start();

try {
    $router = new PFW\Core\Router();
    $router->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}
