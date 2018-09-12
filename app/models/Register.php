<?php

namespace PFW\Models;

use PFW\Core\Model;

class Register extends Model
{
    public $data;
    private $auth;

    public function __construct(array $data)
    {
        //parent::__construct();
        $this->data = $data;
        $this->auth = new Auth($data);
    }

    public function signUp(): array
    {
        $errors = $this->auth->checkData();
        $user_isset = $this->auth->user->issetUser($this->data);
        if ($user_isset) {
            $errors[] = 'An account already exists with this login or email address.';
        }
        if (empty($errors)) {
            if (!$this->auth->user->addUser($this->data)) {
                $errors[] = 'User didnt to add';
            }
        }
        return $errors;
    }
}
