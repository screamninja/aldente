<?php

namespace PFW\Config;

/**
 * Class RouterConfig
 * @package PFW\Config
 */
class RouterConfig
{
    /**
     * @return array with routes
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

            // TODO: add news method in to pages controller
            'news' => [
                'controller' => 'pages',
                'action' => 'news',
            ],

            // TODO: add json method in to pages controller
            'features/api' => [
                'controller' => 'pages',
                'action' => 'api',
            ],

            // TODO: add ajax method in to pages controller
            'features/ajax' => [
                'controller' => 'pages',
                'action' => 'ajax',
            ],

            // TODO: add logger method in to pages controller
            'features/logger' => [
                'controller' => 'pages',
                'action' => 'logger',
            ],

            // TODO: add about method in to pages controller
            'about' => [
                'controller' => 'pages',
                'action' => 'about',
            ],
            // TODO: add contact method in to pages controller
            'contact' => [
                'controller' => 'pages',
                'action' => 'contact',
            ],
        ];
    }
}
