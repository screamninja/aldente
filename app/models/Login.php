<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class Login
 * @package PFW\Models
 */
class Login extends Model
{

    /**
     * @var array
     */
    public $data;
    /**
     * @var User
     */
    private $user;

    /**
     * Login constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
        $this->user = new User();
    }

    /**
     * @return array
     */
    public function getLogData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
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

    /**
     * @param array $stmt
     * @return bool
     */
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

    /**
     * @return array
     */
    public function login(): array
    {
        $errors = $this->checkLogData();
        $get_user = $this->user->getUser($this->data);
        if (empty($errors)) {
            if (isset($get_user)) {
                if (empty($get_user['error'])) {
                    $verify = $this->checkPassword($get_user);
                    if ($verify) {
                        $_SESSION['logged_user'] = $get_user['login'];
                        header('Location: /');
                    } else {
                        $errors[] = 'Password is incorrect! Try again.';
                    }
                } else {
                    $errors[] = 'Users with that login not found! Try again or sign up on this site.';
                }

            } else {
                $errors[] = 'Users with that login not found! Try again or sign up on this site.';
            }
        }
        return $errors;
    }
}
