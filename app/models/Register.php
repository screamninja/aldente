<?php

namespace PFW\Models;

use PFW\Core\Model;

class Register extends Model
{
    public $data;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function checkData($data)
    {

    }

    public function signUp(): array
    {
        if (isset($this->data['do_signup'])) {
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
            if ($this->db->loginMatch($this->data) > 0) {
                $errors[] = 'User with that login already exists';
            }
            if ($this->db->emailMatch($this->data) > 0) {
                $errors[] = 'User with that email already exists';
            }
            if (empty($errors)) {
                $this->db->insert($this->data);
                //echo '<div style = "color: green;">Registration successful!</div><hr>';
            } else {
                return $errors;
                //echo '<div style = "color: red;">'.array_shift($errors).'</div><hr>';
            }
        }
        return [];
    }
}
