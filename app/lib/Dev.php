<?php


namespace PFW\Lib;

class Dev
{
    public function debug($str)
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
    }
}
