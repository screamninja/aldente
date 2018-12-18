<?php

namespace AlDente\Config;

use AlDente\Lib\Logger;
use AlDente\Lib\Routes\FileRoute;
use AlDente\Lib\Routes\DbRoute;
use AlDente\Lib\Routes\SyslogRoute;

/**
 * Class LoggerConfig
 * @package AlDente\Config
 *
 * These are in order of highest priority to lowest.
 *
 * use Psr\Log\LogLevel;
 *
 * LogLevel::EMERGENCY;
 * LogLevel::ALERT;
 * LogLevel::CRITICAL;
 * LogLevel::ERROR;
 * LogLevel::WARNING;
 * LogLevel::NOTICE;
 * LogLevel::INFO;
 * LogLevel::DEBUG;
 */
class LoggerConfig
{
    /**
     * @var Logger
     */
    private static $logger;

    /**
     * Config for logs in to:
     * 1) Log file at path (default path: app/logs/default.log);
     * 2) Db in table logs (default table name: logs);
     * 3) System logs.
     * @return Logger
     */
    public static function getLogger(): Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger();

            self::$logger->routes->attach(new FileRoute([
                'isEnable' => true,
                'filePath' => 'logs/default.log',
            ]));
            self::$logger->routes->attach(new DbRoute([
                'isEnable' => true,
                'table' => 'logs',
            ]));
            self::$logger->routes->attach(new SyslogRoute([
                'isEnable' => true,
            ]));
        }
        return self::$logger;
    }
}
