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
            'joindate' => $joinDate,
            'unixtime' => $unixTime
        ];
        $stmt = $this->db->query(
            "INSERT INTO users (login, email, password, join_date, unix_timestamp)
                 VALUES (:login, :email, :password, :joindate, :unixtime)",
            $param
        );
        return $stmt->setFetchMode();
    }
}
