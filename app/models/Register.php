<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class Register
 * @package PFW\Models
 */
class Register extends Model
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
     * Register constructor.
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
    public function getRegData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    private function checkRegData(): array
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
        }
        return $errors;
    }

    /**
     * @return array
     */
    public function signUp(): array
    {
        $errors = $this->checkRegData();
        $user_isset = $this->user->issetUser($this->data);
        if ($user_isset) {
            $errors[] = 'An account already exists with this login or email address.';
        }
        if (empty($errors)) {
            if (!$this->user->addUser($this->data)) {
                $errors[] = 'User didnt to add';
            }
        }
        return $errors;
    }
}
