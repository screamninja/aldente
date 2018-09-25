<?php

namespace PFW\Models;

use PFW\Core\Model;

class Register extends Model
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function signUp(Auth $auth, User $user): array
    {
        $errors = $auth->checkData();
        $user_isset = $user->issetUser($this->data);
        if ($user_isset) {
            $errors[] = 'An account already exists with this login or email address.';
        }
        if (empty($errors)) {
            if (!$user->addUser($this->data)) {
                $errors[] = 'User didn\'t to add';
            }
        }
        return $errors;
    }
}
