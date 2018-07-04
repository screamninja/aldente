<?php

namespace PFW\Core;

abstract class Controller
{
    public $route;

    public function __construct($route)
    {
        $this->route = $route;
        // echo '<p>HELLO!</p>';
    }
}