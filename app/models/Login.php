<?php

namespace PFW\Models;

use PFW\Core\Model;

class Login extends Model
{

    public $data;
    private $user;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
        $this->user = new User();
    }

    public function getLogData(): array
    {
        return $this->data;
    }

    private function checkLogData(): array
    {
        $errors = [];
        if (isset($this->data['do_login'])) {
            if (trim($this->data['login']) == '') {
                $errors[] = 'Login is required';
            }
            if ($this->data['password'] == '') {
                $errors[] = 'Password is required';
            }
        }
        return $errors;
    }

    private function checkPassword(array $stmt): bool
    {
        $password = $this->data['password'];
        $hash = $stmt['password'];
        if (isset($stmt)) {
            $password_verify = password_verify($password, $hash);
            if ($password_verify) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login(): array
    {
        $errors = $this->checkLogData();
        $get_user = $this->user->getUser($this->data);
        if (empty($errors)) {
            if (isset($get_user)) {
                $verify = $this->checkPassword($get_user);
                if ($verify) {
                    $_SESSION['logged_user'] = $get_user['login'];
                    echo '<div style="color: green;">Welcome, '.$_SESSION['logged_user'].'</div></<br>';
                    echo '<div><a href="/">Go to Main page</a></div></br>';
                } else {
                    $errors[] = 'Password is incorrect! Try again.';
                }
            } else {
                $errors[] = 'Users with that login not found! Try again or sign up on this site.';
            }
        }
        return $errors;
    }
}
