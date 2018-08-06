<?php

namespace PFW\Controllers;

use PFW\Core\Controller;

class AccountController extends Controller
{
    public function loginAction()
    {
        $this->view->render('Login Page');
    }

    public function registerAction()
    {
        $this->view->render('Sign Up Page');
    }
}
