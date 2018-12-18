<?php

require_once '../vendor/autoload.php';

try {
    $router = new AlDente\Core\Router();
    $router->run();
} catch (Throwable $e) {
    $logger = \AlDente\Config\LoggerConfig::getLogger();
    $logger->error($e->getMessage());
    echo $e->getMessage();
}
