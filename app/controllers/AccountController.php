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
     * @var \PFW\Models\User
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
     *
     */
    public function loginAction()
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
     *
     */
    public function logoutAction()
    {
        unset($_SESSION['logged_user']);
        $this->view->redirect('/');
        exit;
    }

    /**
     *
     */
    public function registerAction()
    {
        $vars = array();
        if ($_POST) {
            $register = new Register($_POST);
            $errors = $register->exception;
            if ($errors) {
                $vars = [
                    'errors' => [$errors],
                    'data' => ['do_sign_up' => 1],
                ];
            } else {
                $errors = $register->signUp($this->auth, $this->user);
                $vars = [
                    'errors' => $errors,
                    'data' => $this->auth->getData(),
                ];
            }
        }
        $this->view->render('Sign Up Page', $vars, true);
    }
}
