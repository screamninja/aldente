<?php

require_once '../vendor/autoload.php';

use PFW\Core\Router;

$dir_name = dirname(__DIR__) . '/';
define('PROJECT_DIR', $dir_name);

session_start();

try {
    $router = new Router();
    $router->run();
} catch (Throwable $e) {
    $logger = \PFW\Config\LoggerConfig::getLogger();
    $logger->error($e->getMessage());
    echo $e->getMessage();
}
