<?php

namespace AlDente\Models;

use AlDente\Core\Model;

/**
 * Class Login
 * @package AlDente\Models
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
     * Checking data from form, get user data from Db, verify password and if all is correct set in session logged user
     * or return error
     * @param Auth $auth
     * @param User $user
     * @return array
     */
    public function login(Auth $auth, User $user): array
    {
        $notice = $auth->checkData();
        $userData = $user->getUser($this->data);
        if (empty($notice)) {
            if (empty($userData['error'])) {
                $verify = $auth->checkPassword($userData);
                if ($verify) {
                    $_SESSION['logged_user'] = $userData['login'];
                    $_SESSION['logged_email'] = $userData['email'];
                    $notice['user'] = $userData['login'];
                } else {
                    $notice['error'][] = 'Password is incorrect! Try again.';
                }
            } else {
                $notice['error'][] = 'Users with that login not found! Try again or sign up on this site.';
            }
        }
        return $notice;
    }
}
