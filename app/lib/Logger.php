<?php

namespace PFW\Lib;

use SplObjectStorage;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package PFW\Lib
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * @var SplObjectStorage
     */
    public $routes;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        $this->routes = new SplObjectStorage();
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        foreach ($this->routes as $route) {
            if (!$route instanceof LoggerRoute) {
                continue;
            }
            if (!$route->isEnable) {
                continue;
            }
            $route->log($level, $message, $context);
        }
    }
}
