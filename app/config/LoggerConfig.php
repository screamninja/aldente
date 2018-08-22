<?php

namespace PFW\Config;

use PFW\Lib\Logger;
use PFW\Lib\Routes\FileRoute;
use PFW\Lib\Routes\DbRoute;
use PFW\Lib\Routes\SyslogRoute;

// use Psr\Log\LogLevel;

/**
 * Class LoggerConfig
 * @package PFW\Config
 */
class LoggerConfig
{
    /**
     * @var
     */
    private static $logger;

    /**
     * @return Logger
     */
    public static function getLogger()
    {
        if (!self::$logger) {
            self::$logger = new Logger();

            self::$logger->routes->attach(new FileRoute([
                'isEnable' => true,
                'filePath' => 'app/logs/default.log',
            ]));
            self::$logger->routes->attach(new DbRoute([
                'isEnable' => true,
                'table' => 'logs',
            ]));
            self::$logger->routes->attach(new SyslogRoute([
                'isEnable' => true
            ]));
        }
        return self::$logger;
    }
}

/*
These are in order of highest priority to lowest.

LogLevel::EMERGENCY;
LogLevel::ALERT;
LogLevel::CRITICAL;
LogLevel::ERROR;
LogLevel::WARNING;
LogLevel::NOTICE;
LogLevel::INFO;
LogLevel::DEBUG;
*/
