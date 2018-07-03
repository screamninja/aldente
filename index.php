<?php

require_once 'vendor/autoload.php'; // Автозагрузка классов через Composer

session_start();

echo 'Hello, World!';

try {
    $var1 = new PFW\core\Router();
} catch (Throwable $e) {
    echo $e->getMessage();
}
