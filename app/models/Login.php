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
    private $auth;

    /**
     * Login constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->auth = new Auth($data);
    }

    /**
     * @return array
     */
    public function login(): array
    {
        $errors = $this->auth->checkData();
        $user = $this->auth->user->getUser($this->data);
        if (empty($errors)) {
            if (isset($user)) {
                if (empty($user['error'])) {
                    $verify = $this->auth->checkPassword($user);
                    if ($verify) {
                        $_SESSION['logged_user'] = $user['login'];
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
