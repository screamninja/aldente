<?php

namespace AlDente\Config;

/**
 * Class DatabaseConfig
 * @package AlDente\Config
 */
class DatabaseConfig
{
    /**
     * Db connect configuration
     * @return array
     */
    public static function get(): array
    {
        return [
            'host' => 'localhost',
            'name' => 'aldente_db',
            'user' => 'aldente_admin',
            'password' => 'aldente_pass',
        ];
    }
}
