<?php

namespace PFW\Models;

use PFW\Core\Model;

class Register extends Model
{
    public $data;
    private $user;

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

    private function checkData()
    {
        if (isset($this->data['do_sign_up'])) {
            $errors = [];
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
            return $errors;
        }
    }

    public function signUp()
    {
        $errors = $this->checkData();
        $check = $this->user->checkUser($this->data);

        if (empty($errors) and $check == true) {
            $this->user->addUser($this->data);
        }
        return $errors;
    }
}
