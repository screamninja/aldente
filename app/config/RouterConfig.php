<?php

namespace PFW\Config;

class RouterConfig
{
    public static function get()
    {
        return [

            '' => [
                'controller' => 'main',
                'action' => 'index',
            ],

            'account/login' => [
                'controller' => 'account',
                'action' => 'login',
            ],

            'account/register' => [
                'controller' => 'account',
                'action' => 'register',
            ],

        ];
    }
}
