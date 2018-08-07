<?php

namespace PFW\Lib;

use PDO;
use PDOException;
use PFW\Config\DatabaseConfig;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = DatabaseConfig::get();
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
            $this->db = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . '',
                $config['user'],
                $config['password'],
                $options
            );
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function insert($data = [])
    {
        $login = $data['login'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $unixTime = time();
        $joinDate = date("r", $unixTime);

        $stmt = $this->db->prepare("INSERT INTO users (login,
                                                                email,
                                                                password,
                                                                join_date,
                                                                unix_timestamp)
                                                        VALUES (:login,
                                                                :email,
                                                                :password,
                                                                :joindate,
                                                                :unixtime)
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

    public function loginMatch(string $data_base, $where = [])
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
    }

    public function emailMatch($data = [])
    {
        $email = $data['email'];
        $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
        $result = $this->query($sql);
        $result->execute();
        return $result;
    }
}
