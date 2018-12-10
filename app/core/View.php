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
     * Return error code: 403, 404, etc.
     * @param $code
     * @return void error page
     */
    public static function errorCode($code): void
    {
        http_response_code($code);
        $path = '../app/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    /**
     * Render called page
     * @param $title
     * @param array $vars
     * @param bool $html default is true; if is true - HTML, if is false - JSON or other data format
     * @return void
     */
    public function render(string $title, array $vars, bool $html = true): void
    {
        if ($html) {
            $path = '../app/views/' . $this->path . '.php';
            extract($vars, EXTR_SKIP);
            if (file_exists($path)) {
                ob_start();
                require $path;
                $content = ob_get_clean();
                require '../app/views/layouts/' . $this->layout . '.php';
            } else {
                echo 'View not found: ' . $this->path;
            }
        } elseif (!isset($vars['error']) && isset($vars['api_data'])) {
            $content = $vars['api_data'];
            require PROJECT_DIR . 'views/api/get.php';
        } else {
            $content = $vars['error'] ?? 'Something went wrong... Please contact with our support.';
            require PROJECT_DIR . 'views/api/get.php';
        }
    }

    /**
     * Redirect to acceptable location
     * @param $url
     * @return void
     */
    public function redirect($url): void
    {
        header('location: ' . $url);
        exit;
    }
}
