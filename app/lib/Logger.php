<?php

namespace PFW\Lib;

use SplObjectStorage;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    public $routes;

    public function __construct()
    {
        $this->routes = new SplObjectStorage();
    }

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
