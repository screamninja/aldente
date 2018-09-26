<?php

namespace PFW\Models;

use PFW\Core\Model;
use PFW\Lib\Db;

/**
 * Class User
 * @package PFW\Models
 */
class User extends Model
{
    /**
     * @var Db
     */
    private $db;


    /**
     * User constructor.
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        $this->db = $db;
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
            "SELECT COUNT(*) FROM users 
                 WHERE email = :email",
            $param2
        );
        $isset_email = $stmt_email->fetchColumn();
        if ($isset_login || $isset_email) {
            return true;
        }
        return false;
    }

    /**
     * @param string $user_id
     * @return bool
     */
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
        $stmt = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt = array_shift($stmt);
        if ($stmt === null) {
            return ['error' => 'User not found!'];
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

    /**
     * @param string $login
     * @return array|bool|string
     */
    public function addApiToken(string $login)
    {
        $user_data = $this->db->row(
            "SELECT * FROM users
                  WHERE login = :login",
            $param = ['login' => $login]
        );
        $user_data = array_shift($user_data);
        if (isset($user_data) || is_array($user_data)) {
            $user_id = $user_data['id'];
            if (!$this->issetUserId($user_id)) {
                $email = $user_data['email'];
                $token = password_hash($login . $email, PASSWORD_DEFAULT);
                $stmt = $this->db->query(
                    "INSERT INTO api (user_id, token, last_get)
                          VALUES (:user_id, :token, NOW())",
                    $param = [
                        'user_id' => $user_id,
                        'token' => $token,
                    ]
                );
                if ($stmt) { //return true on success or false on error
                    return $return = [
                        'token' => $token,
                    ];
                } else {
                    return $return = [
                        'error' => 'Something went wrong... Please contact with our support.',
                    ];
                }
            } else {
                $return = [
                    'error' => 'User ' . $login . ' already got the Key!',
                ];
            }
        } else {
            $return = [
                'error' => 'Something went wrong... Please contact with our support.',
            ];
        }
        return $return;
    }
}
