<?php

namespace PFW\Models;

use PFW\Core\Model;

class Auth extends Model
{
    public $data;
    public $user;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
        $this->user = new User();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function checkData(): array
    {
        $errors = [];
        if (isset($this->data['do_sign_up'])) {
            if (trim($this->data['login']) == '') {
                $errors[] = 'Login is required';
            }
            if (trim($this->data['email']) == '') {
                $errors[] = 'Email is required';
            }
            if ($this->data['password'] == '') {
                $errors[] = 'Password is required';
            }
            if ($this->data['password_2'] != $this->data['password']) {
                $errors[] = 'Password do not match';
            }
        } elseif (isset($this->data['do_login'])) {
            if (trim($this->data['login']) == '') {
                $errors[] = 'Login is required';
            }
            if ($this->data['password'] == '') {
                $errors[] = 'Password is required';
            }
        }
        return $errors;
    }

    public function checkPassword(array $stmt): bool
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
}
