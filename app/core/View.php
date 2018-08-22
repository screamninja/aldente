<?php

namespace PFW\Core;

/**
 * Class View
 * @package PFW\Core
 */
class View
{
    /**
     * @var string
     */
    public $path;
    /**
     * @var
     */
    public $route;
    /**
     * @var string
     */
    public $layout = 'default';

    /**
     * View constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    /**
     * @param $title
     * @param array $vars
     */
    public function render($title, $vars = [])
    {
        $path = '../app/views/' . $this->path . '.php';
        extract($vars);
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require '../app/views/layouts/' . $this->layout . '.php';
        } else {
            echo 'View not found: ' . $this->path;
        }
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    /**
     * @param $code
     */
    public static function errorCode($code)
    {
        http_response_code($code);
        $path = '../app/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    /**
     * @param $status
     * @param $message
     */
    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    /**
     * @param $url
     */
    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }
}