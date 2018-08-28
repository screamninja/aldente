<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class User
 * @package PFW\Models
 */
class User extends Model
{
    /**
     * User constructor.
     * @param array $data
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function issetUser(array $data): bool
    {
        $login = $data['login'];
        $email = $data['email'];
        $param1 = ['login' => $login];
        $param2 = ['email' => $email];
        $stmt_login = $this->db->query(
            "SELECT COUNT(*) FROM users
                 WHERE login = :login",
            $param1
        );
        $isset_login = $stmt_login->fetchColumn();
        $stmt_email = $this->db->query(
            "SELECT COUNT(*) 
                 FROM users 
                 WHERE email = :email",
            $param2
        );
        $isset_email = $stmt_email->fetchColumn();
        if ($isset_login || $isset_email) {
            return true;
        }
        return false;
    }

    public function issetUserId(string $user_id): bool
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM api
                 WHERE user_id = :user_id",
            $param = ['user_id' => $user_id]
        );
        $isset_user_id = $stmt->fetchColumn();
        if ($isset_user_id) {
            return true;
        }
        return false;
    }
    /**
     * @param array $data
     * @return array
     */
    public function getUser(array $data): array
    {
        $login = $data['login'];
        $param = ['login' => $login];
        $stmt = $this->db->query(
            "SELECT * FROM users
                 WHERE login = :login",
            $param
        );
        $stmt = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
        $error = ['error' => 'User not found!'];
        if ($stmt == null) {
            return $error;
        } else {
            return $stmt;
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function addUser(array $data): bool
    {
        $login = $data['login'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $unixTime = time();
        $joinDate = date("r", $unixTime);
        $param = [
            'login' => $login,
            'email' => $email,
            'password' => $password,
            'join_date' => $joinDate,
            'unix_time' => $unixTime
        ];
        $stmt = $this->db->query(
            "INSERT INTO users (login, email, password, join_date, unix_timestamp)
                 VALUES (:login, :email, :password, :join_date, :unix_time)",
            $param
        );
        return $stmt->setFetchMode(\PDO::FETCH_ASSOC);
    }

    public function addApiToken(string $login)
    {
        $stmt = $this->db->row(
            "SELECT * FROM users
             WHERE login = :login",
            $param = ['login' => $login]
        );
        $user_data = $stmt[0];
        $user_id = $user_data['id'];
        $email = $user_data['email'];
        $token = password_hash($login . $email, PASSWORD_DEFAULT);
        if (!$this->issetUserId($user_id)) {
            $stmt = $this->db->query(
                "INSERT INTO api (user_id, token, last_get)
             VALUES (:user_id, :token, NOW())",
                $param = [
                    'user_id' => $user_id,
                    'token' => $token
                ]
            );
            if ($stmt) {
                return $token;
            }
            return $error = ['Something went wrong... Please contact with our support.'];
        }
        return $error = ['error' => 'User ' . $login . ' already got the Key!'];
    }
}
