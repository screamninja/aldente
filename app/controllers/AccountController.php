<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\Auth;
use PFW\Models\Login;
use PFW\Models\Register;

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
     * AccountController constructor.
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        $this->auth = new Auth($_POST);
    }

    /**
     *
     */
    public function loginAction()
    {
        $vars = array();
        if ($_POST) {
            $login = new Login($_POST);
            $errors = $login->login();
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
                $errors = $register->signUp();
                $vars = [
                    'errors' => $errors,
                    'data' => $this->auth->getData(),
                ];
            }
        }
        $this->view->render('Sign Up Page', $vars, true);
    }
}
