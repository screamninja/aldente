<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\Auth;
use PFW\Models\Login;
use PFW\Models\Register;
use PFW\Models\User;
use PFW\Lib\Db;

/**
 * Class AccountController
 * @package PFW\Controllers
 */
class AccountController extends Controller
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
     * AccountController constructor.
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
     * Login action
     * Receives data from the forms and sends it to login method in Login model.
     * @return void
     */
    public function loginAction(): void
    {
        $vars = array();
        if ($_POST) {
            $login = new Login($_POST);
            $errors = $login->login($this->auth, $this->user);
            $vars = [
                'errors' => $errors,
                'data' => $this->auth->getData(),
            ];
        }
        $this->view->render('Login Page', $vars, true);
    }

    /**
     * Log out action
     * Unset session for logged user and redirect to main page
     * @return void
     */
    public function logoutAction(): void
    {
        unset($_SESSION['logged_user']);
        $this->view->redirect('/');
        exit;
    }

    /**
     * Register action
     * Receives data from the forms and sends it to sign up method in Register model.
     * @return void
     */
    public function registerAction(): void
    {
        $vars = [];
        if ($_POST) {
            $register = new Register($_POST);
            $notice = $register->signUp($this->auth, $this->user);
            if ($notice['error']) {
                $vars = [
                    'error' => $notice['error'],
                ];
            } else {
                $vars = [
                    'user' => $notice['user'],
                ];
            }
        }
        $this->view->render('Sign Up Page', $vars, true);
    }
}
