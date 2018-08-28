<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\API;
use PFW\Models\User;

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
        $this->view->render('About API', $vars, true);
    }

    /**
     *
     */
    public function tokenAction()
    {
        $vars = array();
        if (isset($_POST['get_token'])) {
            $user = new User();
            $token = $user->addApiToken($_SESSION['logged_user']);
            if (!isset($token ['error'])) {
                $vars = [
                    'token' => $token['token']
                ];
            } else {
                $vars = ['error' => $token['error']];
            }
        }
        $this->view->render('Get API Key', $vars, true);
    }

    /**
     *
     */
    public function getAction()
    {
        $post = fopen('php://input', 'r');
        $data = json_decode(stream_get_contents($post), true);
        fclose($post);
        $method = $data['method'] ?? false;
        $token = $_SERVER['HTTP_X_AUTHORIZATION_TOKEN'];
        $user = new User();
        $user_id = $user->getUserIdbyToken($token);
        $api = new API($user_id);
        if (method_exists($api, $method)) {
            $params = $data['params'] ?? [];
            try{
                $res = call_user_func_array([$api,$method], $params);
            } catch (\Throwable $e) {

            }
        } else {
            View::errorCode(404);
        }
        $vars = [
            'news' => $api->encodeNews()
        ];
        $this->view->render('Response Page', $vars);
    }
}
