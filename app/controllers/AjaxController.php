<?php

namespace PFW\Controllers;

use PFW\Core\Controller;
use PFW\Lib\Db;
use PFW\Models\Auth;
use PFW\Models\User;
use PFW\Models\Login;
use PFW\Models\Register;
use PFW\Models\API;

class AjaxController extends Controller
{
    protected $auth;
    protected $user;

    public function __construct($route)
    {
        parent::__construct($route);
        $db = Db::init();
        $this->auth = new Auth($_POST);
        $this->user = new User($db);
    }

    public function loginAction()
    {
        if ($_POST) {
            $login = new Login($_POST);
            $notice = $login->login($this->auth, $this->user);
            echo json_encode($notice);
        }
    }

    public function registerAction()
    {
        if ($_POST) {
            $register = new Register($_POST);
            $notice = $register->signUp($this->auth, $this->user);
            if (!$notice) {
                $notice['succes'] = 'OK!';
            }
            echo json_encode($notice);
        }
    }

    public function tokenAction()
    {
        //
    }
}
