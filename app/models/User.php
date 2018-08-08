<?php

namespace PFW\Models;

use PFW\Core\Model;
use PFW\Lib\Db;

class User extends Model
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        $register_obj = new Register();
        $this->data = $register_obj->getData();
    }

    public function checkUser()
    {
        $where_str = '';
        foreach ($where as $key => $value) {
            $where_str .= "$key = $value AND ";
        }
        trim();
        $sql = "SELECT COUNT(*) FROM users WHERE login = '$login'";
        $result = $this->query($sql);
        $result->execute();
        $res = $result->fetchColumn();
        return $res;

        $email = $data['email'];
        $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
        $result = $this->query($sql);
        $result->execute();
        return $result;
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
