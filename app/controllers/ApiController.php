<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Core\View;
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
        $this->view->render('Get API Token', $vars, true);
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
        $api = new API($token);
        if (method_exists($api, $method)) {
            $id = $data['id'];
            $params = $data['params'] ?? ['count' => '5'];
            $params += ['id' => $id];
            $result = call_user_func_array([$api, $method], $params);
            if ($result) {
                return $result;
            }
        } else {
            View::errorCode(404);
        }
        $vars = [
            'news' => $result ?? ''
        ];
        $this->view->render('Response Page', $vars, false);
    }
}
