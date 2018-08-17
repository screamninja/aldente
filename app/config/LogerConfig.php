<?php

namespace PFW\Config;

use PFW\Lib\Logger;
use PFW\Lib\Routes\FileRoute;
use PFW\Lib\Routes\DbRoute;

class LoggerConfig
{
    private static $logger;

    public static function getLogger()
    {
        if (!self::$logger) {
            self::$logger = new Logger();

            self::$logger->routes->attach(new FileRoute([
                'isEnable' => true,
                'filePath' => 'data/default.log',
            ]));
            self::$logger->routes->attach(new DbRoute([
                'isEnable' => true,
                'dsn' => 'sqlite:data/default.sqlite',
                'table' => 'default_log',
            ]));
        }
        return self::$logger;
    }
}

/*
$logger->info("Info message");
$logger->alert("Alert message");
$logger->error("Error message");
$logger->debug("Debug message");
$logger->notice("Notice message");
$logger->warning("Warning message");
$logger->critical("Critical message");
$logger->emergency("Emergency message");
*/
