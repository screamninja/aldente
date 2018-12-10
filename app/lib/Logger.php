<?php

namespace PFW\Lib;

use SplObjectStorage;
use Psr\Log\AbstractLogger;

/**
 * Class Logger
 * @package PFW\Lib
 */
class Logger extends AbstractLogger
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
     * Adds logs according with adjusted settings and routes.
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array()): void
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
