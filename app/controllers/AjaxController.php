<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Lib\Db;
use PFW\Models\Auth;
use PFW\Models\User;
use PFW\Models\Login;
use PFW\Models\Register;

/**
 * Class AjaxController
 * @package PFW\Controllers
 */
class AjaxController extends Controller
{
    /**
     * @var Auth
     */
    protected $auth;
    /**
     * @var User
     */
    protected $user;

    /**
     * AjaxController constructor.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $db = Db::init();
        $this->auth = new Auth($_POST);
        $this->user = new User($db);
    }

    /**
     * Switch action
     * Turn On/Off AJAX for forms
     * @return void
     */
    public function switchAction(): void
    {
        if (isset($_POST['ajax'])) {
            $_SESSION['ajax_switch_off'] = '1';
        }
    }

    /**
     * Login action
     * Receives data from the forms and sends it to login method in Login model.
     * @return void
     */
    public function loginAction(): void
    {
        if ($_POST) {
            $login = new Login($_POST);
            $notice = $login->login($this->auth, $this->user);
            echo json_encode($notice);
        }
    }

    /**
     * Register action
     * Receives data from the forms and sends it to sign up method in Register model.
     * @return void
     */
    public function registerAction(): void
    {
        if ($_POST) {
            $register = new Register($_POST);
            $notice = $register->signUp($this->auth, $this->user);
            echo json_encode($notice);
        }
    }

    /**
     * Token action
     * Receives data from the forms and sends it to add API token method in User model.
     * @return void
     */
    public function tokenAction(): void
    {
        if (isset($_POST['get_token'])) {
            $token = $this->user->addApiToken($_SESSION['logged_user']);
            if (!isset($token['error'])) {
                $notice = [
                    'token' => $token['token'],
                ];
            } else {
                $notice = [
                    'error' => $token['error'],
                ];
            }
            echo json_encode($notice);
        }
    }
}
