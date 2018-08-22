<?php

namespace PFW\Config;

/**
 * Class DatabaseConfig
 * @package PFW\Config
 */
class DatabaseConfig
{
    /**
     * @return array
     */
    public static function get(): array
    {
        return [

            'host' => 'localhost',
            'name' => 'pfw_db',
            'user' => 'pfw_admin',
            'password' => 'pfw_pass',
        ];
    }
}
