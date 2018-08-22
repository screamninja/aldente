<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class API
 * @package PFW\Models
 */
class API extends Model
{
    public $params;

    public function __construct()
    {
        parent::__construct();
        $uri = $_SERVER['REQUEST_URI'];
        $url = trim($uri, '/');
        $cut = substr($url, 5);
        $uid = substr($cut, 3, 2);
        $key = substr($cut, 10);
        $this->params = [
            'uid' => $uid,
            'key' => $key
        ];
    }

    public function checkUid()
    {
        $user_id = $this->params['uid'];
        $api_key = $this->params['key'];
        $stmt1 = $this->db->query(
            "SELECT COUNT(*) FROM api_counter
                 WHERE user_id = :user_id",
            $param = ['user_id' => $user_id]
        );
        $check_uid = $stmt1->fetchColumn();
        $stmt2 = $this->db->query(
            "SELECT COUNT(*) FROM api_counter
                 WHERE api_key = :api_key",
            $param = ['api_key' => $api_key]
        );
        $check_key = $stmt2->fetchColumn();
        if (($check_uid == 1) and ($check_key == 1)) {
            return true;
        }
        return false;
    }

    public function checkCount()
    {
        $user_id = $this->params['uid'];
        $stmt = $this->db->query(
            "SELECT daily_count FROM api_counter
                 WHERE user_id = :user_id",
            $param = ['user_id' => $user_id]
        );
        $arr_count = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
        $check_count = $arr_count['daily_count'];
        if ($check_count <= 100) {
            $this->db->query(
                "UPDATE api_counter SET daily_count=:daily_count, last_get=NOW()
                 WHERE user_id = :user_id",
                $param = [
                    'user_id' => $user_id,
                    'daily_count' => ++$check_count
                ]
            );
            return true;
        } else {
            /*$stmt = $this->db->query(
                "SELECT last_get FROM api_counter
                 WHERE user_id = :user_id",
                $param = ['user_id' => $user_id]
            );
            $arr_last_get = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
            $last_get = $arr_last_get['last_get'];*/
            $arr_date_diff = $this->db->query(
                "SELECT DATEDIFF (dd, last_get, NOW())
                     FROM api_counter
                     WHERE user_id=:user_id",
                $param = ['user_id' => $user_id]
            );
            $arr_date_diff->fetchAll(\PDO::FETCH_ASSOC)[0];
            $date_diff = $arr_date_diff['datediff'];
            if ($date_diff == 0) {
                $this->db->query(
                    "UPDATE api_counter SET daily_count=1, last_get=NOW()
                 WHERE user_id = :user_id",
                    $param = ['user_id' => $user_id]
                );
                return true;
            }
            return false;
        }
    }

    /**
     * @return array
     */
    public function getNews(): array
    {
        if ($this->checkUid()) {
            if ($this->checkCount()) {
                $result = $this->db->row('SELECT * FROM news');
                $result = $result[0];
                return $result;
            }
            return $result = [
                'error' => 'invalid_request',
                'error_description' => 'the number of allowed requests (100) is exceeded!'
            ];
        } else {
            $result = [
                'error' => 'invalid_request',
                'error_description' => 'account not found'
            ];
            return $result;
        }
    }

    /**
     * @return string
     */
    public function encodeNews()
    {
        $news = $this->getNews();
        $news_json = json_encode($news, JSON_PRETTY_PRINT);
        return $news_json;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function issetUid($user_id)
    {
        $param = ['user_id' => $user_id];
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM api_counter
                 WHERE user_id = :user_id",
            $param
        );
        $isset_uid = $stmt->fetchColumn();
        if ($isset_uid) {
            return true;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function addKey()
    {
        $login = $_SESSION['logged_user'];
        $user_data = $this->db->row(
            "SELECT * FROM users
             WHERE login = :login",
            $param = ['login' => $login]
        );
        $user_data = $user_data[0];
        $user_id = $user_data['id'];
        $email = $user_data['email'];
        $api_key = password_hash($login + $email, PASSWORD_DEFAULT);
        if (!$this->issetUid($user_id)) {
            $stmt = $this->db->query(
                "INSERT INTO api_counter (user_id, api_key)
             VALUES (:user_id, :api_key)",
                $param = [
                    'user_id' => $user_id,
                    'api_key' => $api_key
                ]
            );
            if ($stmt) {
                return $api_key;
            }
            return $error = 'Something went wrong... Please contact with our support.';
        }
        return $error = "User $login already got the Key!";
    }
}
