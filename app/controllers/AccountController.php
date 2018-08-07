<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Models\Register;

class AccountController extends Controller
{
    public function loginAction()
    {
        $this->view->render('Login Page');
    }

    public function registerAction()
    {
        $register_obj = new Register($_POST);
        $errors = $register_obj->signUp();
        $vars = [
            'errors' => $errors,
            'data' => $register_obj->getData(),
        ];
        $this->view->render('Sign Up Page', $vars);
    }
}
