<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\API;

class ApiController extends Controller
{
    public function aboutAction()
    {
        $vars = array();
        $this->view->render('About API', $vars);
    }

    public function keyAction()
    {
        $vars = array();
        if (isset($_POST['get_key'])) {
            $key_obj = new API();
            $key = $key_obj->addKey();
            $vars = [
                'key' => $key
            ];
        }
        $this->view->render('Get API Key', $vars);
    }

    public function getAction()
    {
        $api = new API();
        $vars = [
            'news' =>$api->encodeNews()
        ];
        $this->view->render('Response Page', $vars);
    }
}