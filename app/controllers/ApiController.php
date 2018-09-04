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
        $this->view->render('Get API Token', $vars, true);
    }

    /**
     * @param array $data
     * @return bool
     */
    private function checkResponse(array $data): bool
    {
        $error = false;
        if (isset($data) && is_array($data)) {
            if ($data['jsonrpc'] != '2.0') {
                $error = true;
            }
            if (empty($data['method'])) {
                $error = true;
            }
            if (empty($data['params'])) {
                $error = true;
            }
            if (empty($data['id']) && !is_integer($data['id'])) {
                $error = true;
            }
            if ($error) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function getAction()
    {
        $post = fopen('php://input', 'r');
        if (!empty($post)) {
            $data = json_decode(stream_get_contents($post), true);
            fclose($post);
            $check = $this->checkResponse($data);
            if ($check) {
                $method = $data['method'] ?? false;
                $token = $_SERVER['HTTP_X_AUTHORIZATION_TOKEN'];
                $api = new API($token);
                if (method_exists($api, $method)) {
                    $params = $data['params'] ?? [];
                    try {
                        $result = call_user_func_array([$api, $method], $params);
                    } catch (\Throwable $e) {
                        $logger = \PFW\Config\LoggerConfig::getLogger();
                        $logger->error($e->getMessage());
                        $vars['error'] = [
                            'code' => '-32603',
                            'message' => 'Internal error'
                        ];
                    }
                    $vars['news'] = $result ?? [];
                } else {
                    $vars['error'] = [
                        'code' => '-32601',
                        'message' => 'Method not found'
                    ];
                }
            } else {
                $vars['error'] = [
                    'code' => '-32700',
                    'message' => 'Parse error'
                ];
            }
        } else {
            $vars['error'] = [
                'code' => '-32600',
                'message' => 'Invalid Request'
            ];
        }
        if (isset($vars['error'])) {
            $method = 'jsonError';
            $params = $vars['error'];
            $token = $_SERVER['HTTP_X_AUTHORIZATION_TOKEN'];
            $api = new API($token);
            $result = call_user_func_array([$api, $method], $params);
            $vars['error'] = $result ?? [];
        }
        $this->view->render('Response Page', $vars, false);
    }
}
