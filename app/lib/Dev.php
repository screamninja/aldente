<?php

namespace PFW\Lib;

/**
 * Class Dev
 * @package PFW\Lib
 */
class Dev
{
    /**
     * @param $exp
     */
    public function debug($exp)
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        echo '<pre>';
        var_dump($exp);
        echo '</pre>';
    }
}