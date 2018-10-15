<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class Auth
 * @package PFW\Models
 */
class Auth extends Model
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Auth constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function checkData(): array
    {
        $errors = [];
        if (isset($this->data['do_sign_up'])) {
            if (trim($this->data['login']) == '') {
                $errors['error'][] = ' Login is required';
            }
            if (trim($this->data['email']) == '') {
                $errors['error'][] = ' Email is required';
            }
            if ($this->data['password'] == '') {
                $errors['error'][] = ' Password is required';
            }
            if ($this->data['password_2'] != $this->data['password']) {
                $errors['error'][] = ' Password do not match';
            }
        } elseif (isset($this->data['do_login'])) {
            if (trim($this->data['login']) == '') {
                $errors['error'][] = ' Login is required';
            }
            if ($this->data['password'] == '') {
                $errors['error'][] = ' Password is required';
            }
        } elseif (!isset($this->data['do_sign_up']) && !isset($this->data['do_login'])) {
            $errors['error'][] = '';
        }
        return $errors;
    }

    /**
     * @param array $stmt
     * @return bool
     */
    public function checkPassword(array $stmt): bool
    {
        $password = $this->data['password'];
        $hash = $stmt['password'];
        if (isset($stmt)) {
            $password_verify = password_verify($password, $hash);
            if ($password_verify) {
                return true;
            }
        }
        return false;
    }
}
