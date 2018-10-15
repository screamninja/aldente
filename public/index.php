<?php

require_once '../vendor/autoload.php';

try {
    $router = new PFW\Core\Router();
    $router->run();
} catch (Throwable $e) {
    $logger = \PFW\Config\LoggerConfig::getLogger();
    $logger->error($e->getMessage());
    echo $e->getMessage();
}
