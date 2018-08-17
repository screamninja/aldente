<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\Login;
use PFW\Models\Logout;
use PFW\Models\Register;

class AccountController extends Controller
{
    public function loginAction()
    {
        $vars = array();
        if ($_POST) {
            $login_obj = new Login($_POST);
            $errors = $login_obj->login();
            $vars = [
                'errors' => $errors,
                'data' => $login_obj->getLogData(),
            ];
        }
        $this->view->render('Login Page', $vars);
    }

    public function logoutAction()
    {
        $vars = array();
        if ($_POST) {
            $logout_obj = new Logout($_POST);
            $vars = [
                'data' => $logout_obj->getLogOutData(),
            ];
        }
        $this->view->render('Logout Page', $vars);
    }

    public function registerAction()
    {
        $vars = array();
        if ($_POST) {
            $register_obj = new Register($_POST);
            $err_db = $register_obj->exception;
            if ($err_db) {
                $vars = [
                    'errors' => [$err_db],
                    'data' => ['do_sign_up' => 1],
                ];
            } else {
                $errors = $register_obj->signUp();
                $vars = [
                    'errors' => $errors,
                    'data' => $register_obj->getRegData(),
                ];
            }

        }
        $this->view->render('Sign Up Page', $vars);
    }
}
