<?php

namespace PFW\Config;

class DatabaseConfig
{
    public static function get()
    {
        return [

            'host' => 'localhost',
            'name' => 'pfw_db',
            'user' => 'pfw_admin',
            'password' => 'pfw_pass',
            ];
    }
}
