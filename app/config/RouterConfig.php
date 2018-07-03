<?php

namespace PFW\Config;

class RouterConfig2
{
    public static function get()
    {
        return [

            'account/login' => [
                'controller' => 'account',
                'action' => 'login',
            ],

            'ticker/show' => [
                'controller' => 'ticker',
                'action' => 'show',
            ],
        ];
    }
}
