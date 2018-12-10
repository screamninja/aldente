<?php

namespace PFW\Lib;

/**
 * Class Dev
 * @package PFW\Lib
 */
class Dev
{
    /**
     * Built-in debugger
     * @param $exp
     * @return void
     */
    public function debug($exp): void
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        echo '<pre>';
        var_dump($exp);
        echo '</pre>';
    }
}
