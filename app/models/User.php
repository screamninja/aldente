<?php

namespace PFW\Models;

use PFW\Core\Model;

class User extends Model
{

    public function __construct(array $data)
    {
        parent::__construct();

    }

    public function checkUser(array $data)
    {
        $login = $data['login'];
        $email = $data['email'];

        $stmt_login = $this->db->query("SELECT COUNT(*) FROM users WHERE login = :login", $param1 = ['login' => $login]);
        $stmt_login->execute($param1);
        $check_login = $stmt_login->fetchColumn();

        $stmt_email = $this->db->query("SELECT COUNT(*) FROM users WHERE email = :email", $param2 = ['email' => $email]);
        $stmt_email->execute($param2);
        $check_email = $stmt_email->fetchColumn();

        if ($check_login + $check_email < 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser(array $data)
    {
        $login = $data['login'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $unixTime = time();
        $joinDate = date("r", $unixTime);

        $stmt = $this->db->query("INSERT INTO users (login, email, password, join_date, unix_timestamp)
                                               VALUES (:login, :email, :password, :joindate, :unixtime)
                                  ",
            $param = [
                'login' => $login,
                'email' => $email,
                'password' => $password,
                'joindate' => $joinDate,
                'unixtime' => $unixTime
            ]
        );
        $stmt->execute($param);
    }
}
