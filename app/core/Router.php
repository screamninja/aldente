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
        $arr = RouterConfig::get();
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    /**
     * @param $route
     * @param $params
     */
    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    /**
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
     *
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
