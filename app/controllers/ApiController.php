<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\API;

/**
 * Class ApiController
 * @package PFW\Controllers
 */
class ApiController extends Controller
{
    /**
     *
     */
    public function aboutAction()
    {
        $vars = array();
        $this->view->render('About API', $vars);
    }

    /**
     *
     */
    public function keyAction()
    {
        $vars = array();
        if (isset($_POST['get_key'])) {
            $key_obj = new API();
            $api_data = $key_obj->addKey();
            if (isset($api_data['uid'])) {
                if (isset($api_data['key'])) {
                    $vars = [
                        'uid' => $api_data['uid'],
                        'key' => $api_data['key']
                    ];
                }
            } else {
                $vars = ['error' => $api_data['error']];
            }
        }
        $this->view->render('Get API Key', $vars);
    }

    /**
     *
     */
    public function getAction()
    {
        $api = new API();
        $vars = [
            'news' => $api->encodeNews()
        ];
        $this->view->render('Response Page', $vars);
    }
}