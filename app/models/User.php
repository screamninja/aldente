<?php

namespace PFW\Models;

use PFW\Core\Model;

class User extends Model
{
    private $data;
    private $login;
    private $email;

    public function __construct()
    {
        parent::__construct();
        $this->login = $this->data['login'];
        $this->email = $this->data['email'];
    }

    public function checkUser(array $data)
    {
        $stmt_login = $this->db->query("SELECT COUNT(*) FROM users WHERE login = :login", $param1 = ['login' => $this->login]);
        $stmt_login->execute($param1);
        $check_login = $stmt_login->fetchColumn();

        $stmt_email = $this->db->query("SELECT COUNT(*) FROM users WHERE email = :email", $param2 = ['email' => $this->email]);
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
        $login = $this->data['login'];
        $email = $this->data['email'];
        $password = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $unixTime = time();
        $joinDate = date("r", $unixTime);

        $stmt = $this->db->prepare("INSERT INTO users (login, email, password, join_date, unix_timestamp)
                                               VALUES (:login, :email, :password, :joindate, :unixtime)
                                  ");
        $stmt->execute(
            [
                'login' => $login,
                'email' => $email,
                'password' => $password,
                'joindate' => $joinDate,
                'unixtime' => $unixTime
            ]
        );
    }
}
