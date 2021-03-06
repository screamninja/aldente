<?php

namespace AlDente\Controllers;

use AlDente\Core\Controller;
use AlDente\Lib\Db;
use AlDente\Models\API;
use AlDente\Models\User;

/**
 * Class ApiController
 * @package AlDente\Controllers
 */
class ApiController extends Controller
{
    /**
     * @var Db
     */
    protected $db;

    /**
     * ApiController constructor.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $this->db = Db::init();
    }

    /**
     * Token action
     * Generates a API token for authorized users
     * @return void API token or errors
     */
    public function tokenAction(): void
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
     * Get action
     * JSON-RPC method
     * Receives data from the body of the POST request to the address http://<domain_name>.<dns_zone>/api
     * @return void response (data from Db or errors) in JSON format
     */
    public function getAction(): void
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
            $check = $api->checkRequest($data);
            if ($check) {
                $method = $data['method'] ?? false;
                if (method_exists($api, $method)) {
                    $params = $data['params'] ?? [];
                    try {
                        $result = \call_user_func_array([$api, $method], $params);
                        if ($result === false) {
                            $vars['error'] = [
                                'code' => '-32600',
                                'message' => 'Invalid Request',
                            ];
                        }
                    } catch (\Throwable $e) {
                        $logger = \AlDente\Config\LoggerConfig::getLogger();
                        $logger->error($e->getMessage());
                        $vars['error'] = [
                            'code' => '-32603',
                            'message' => 'Internal error',
                        ];
                    }
                    $vars['api_data'] = $result ?? [];
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
