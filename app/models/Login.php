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
    protected $data;

    /**
     * Login constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param Auth $auth
     * @param User $user
     * @return array
     */
    public function login(Auth $auth, User $user): array
    {
        $notice = $auth->checkData();
        $user = $user->getUser($this->data);
        if (empty($notice)) {
            if (empty($user['error'])) {
                $verify = $auth->checkPassword($user);
                if ($verify) {
                    $_SESSION['logged_user'] = $user['login'];
                    $notice['user'] = $user['login'];
                } else {
                    $notice['error'] = 'Password is incorrect! Try again.';
                }
            } else {
                $notice['error'] = 'Users with that login not found! Try again or sign up on this site.';
            }
        }
        return $notice;
    }
}
