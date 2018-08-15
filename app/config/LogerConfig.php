<?php

namespace PFW\Config;

use PFW\Lib\Logger;
use PFW\Lib\Routes\FileRoute;
use PFW\Lib\Routes\DbRoute;

$logger = new Logger();

$logger->routes->attach(new FileRoute([
    'isEnable' => true,
    'filePath' => 'data/default.log',
]));
$logger->routes->attach(new DbRoute([
    'isEnable' => true,
    'dsn' => 'sqlite:data/default.sqlite',
    'table' => 'default_log',
]));

$logger->info("Info message");
$logger->alert("Alert message");
$logger->error("Error message");
$logger->debug("Debug message");
$logger->notice("Notice message");
$logger->warning("Warning message");
$logger->critical("Critical message");
$logger->emergency("Emergency message");
