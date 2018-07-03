<?php

namespace PFW\core;

use PFW\Config\RouterConfig;
use PFW\Lib\Dev;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = RouterConfig::get();
        $dev = new Dev();
        $dev->debug($arr);
    }

    public function add()
    {
        //
    }

    public function match()
    {
        //
    }

    public function run()
    {
        echo 'start';
    }
}
