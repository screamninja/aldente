<?php

namespace AlDente\Core;

/**
 * Class Controller
 * @package AlDente\Core
 */
abstract class Controller
{
    /**
     * @var
     */
    public $route;
    /**
     * @var View
     */
    public $view;
    /**
     * @var mixed|null|Model
     */
    public $model;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function loadModel(string $name): ?Model
    {
        $path = 'AlDente\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path();
        }
        return null;
    }
}
