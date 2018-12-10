<?php

namespace PFW\Config;

/**
 * Class RouterConfig
 * @package PFW\Config
 */
class RouterConfig
{
    /**
     * Routes
     * @return array
     */
    public static function get(): array
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

            'account/logout' => [
                'controller' => 'account',
                'action' => 'logout',
            ],

            'account/register' => [
                'controller' => 'account',
                'action' => 'register',
            ],

            'api' => [
                'controller' => 'api',
                'action' => 'get',
            ],

            'api/token' => [
                'controller' => 'api',
                'action' => 'token',
            ],

            'ajax/login' => [
                'controller' => 'ajax',
                'action' => 'login',
            ],

            'ajax/register' => [
                'controller' => 'ajax',
                'action' => 'register',
            ],

            'ajax/token' => [
                'controller' => 'ajax',
                'action' => 'token',
            ],

            'ajax/switch' => [
                'controller' => 'ajax',
                'action' => 'switch',
            ],

            'news' => [
                'controller' => 'pages',
                'action' => 'news',
            ],

            'features/api' => [
                'controller' => 'pages',
                'action' => 'api',
            ],

            'features/ajax' => [
                'controller' => 'pages',
                'action' => 'ajax',
            ],

            'features/logger' => [
                'controller' => 'pages',
                'action' => 'logger',
            ],

            'about' => [
                'controller' => 'pages',
                'action' => 'about',
            ],

            'contact' => [
                'controller' => 'pages',
                'action' => 'contact',
            ],
        ];
    }
}
