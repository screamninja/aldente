<?php

require_once 'vendor/autoload.php';

use PFW\Core\Router;

session_start();

try {
    $router = new Router();
    $router->run();
} catch (Throwable $e) {
    $logger = \PFW\Config\LoggerConfig::getLogger();
    $logger->error($e->getMessage());
    echo $e->getMessage();
}
