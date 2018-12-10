<?php

namespace PFW\Core;

use PFW\Config\RouterConfig;

/**
 * Class Router
 * @package PFW\Core
 */
class Router
{
    /**
     * @var array
     */
    protected $routes = [];
    /**
     * @var array
     */
    protected $params = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        session_start();
        $dir_name = \dirname(__DIR__) . '/';
        \define('PROJECT_DIR', $dir_name);
        $arr = RouterConfig::get();
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    /**
     * Add regular expression to routes
     * @param $route
     * @param $params
     * @return void
     */
    public function add($route, $params): void
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    /**
     * Checks for route availability.
     * @return bool
     */
    public function match(): bool
    {
        $uri = $_SERVER['REQUEST_URI'];
        $parse = parse_url($uri);
        $url = trim($parse['path'] ?? '', '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Run called controller or returns 404 error.
     * @return mixed
     */
    public function run()
    {
        if ($this->match()) {
            $path = 'PFW\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}
