<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Lib\Db;
use PFW\Models\API;
use PFW\Models\User;

/**
 * Class ApiController
 * @package PFW\Controllers
 */
class ApiController extends Controller
{
    protected $db;

    public function __construct($route)
    {
        parent::__construct($route);
        $this->db = Db::init();
    }

    /**
     *
     */
    public function aboutAction()
    {
        $vars = [];
        $this->view->render('About API', $vars, true);
    }

    /**
     *
     */
    public function tokenAction()
    {
        $vars = [];
        if (isset($_POST['get_token'])) {
            $user = new User($this->db);
            $token = $user->addApiToken($_SESSION['logged_user']);
            if (!isset($token['error'])) {
                $vars = [
                    'token' => $token['token'],
                ];
            } else {
                $vars = [
                    'error' => $token['error'],
                ];
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
        if (!empty($post)) {
            $data = json_decode(stream_get_contents($post), true);
            if ($data === null) {
                $vars['error'] = [
                    'code' => '-32700',
                    'message' => 'Parse error',
                ];
            }
            fclose($post);
            $token = $_SERVER['HTTP_X_AUTHORIZATION_TOKEN'];
            $api = new API($token, $this->db);
            $check = $api->checkResponse($data);
            if ($check) {
                $method = $data['method'] ?? false;
                if (method_exists($api, $method)) {
                    $params = $data['params'] ?? [];
                    try {
                        $result = call_user_func_array([$api, $method], $params);
                        if ($result === false) {
                            $vars['error'] = [
                                'code' => '-32600',
                                'message' => 'Invalid Request',
                            ];
                        }
                    } catch (\Throwable $e) {
                        $logger = \PFW\Config\LoggerConfig::getLogger();
                        $logger->error($e->getMessage());
                        $vars['error'] = [
                            'code' => '-32603',
                            'message' => 'Internal error',
                        ];
                    }
                    $vars['news'] = $result ?? [];
                } else {
                    $vars['error'] = [
                        'code' => '-32601',
                        'message' => 'Method not found',
                    ];
                }
            } else {
                $vars['error'] = [
                    'code' => '-32700',
                    'message' => 'Parse error',
                ];
            }
        } else {
            $vars['error'] = [
                'code' => '-32600',
                'message' => 'Invalid Request',
            ];
        }
        if (isset($vars['error'])) {
            $result = API::getError($vars['error']);
            $vars['error'] = $result ?? [];
        }
        $this->view->render('Response Page', $vars, false);
    }
}
