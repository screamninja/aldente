<?php

namespace PFW\Models;

use PFW\Core\Model;

class API extends Model
{
    public function getNews(): array
    {
        $result = $this->db->row('SELECT * FROM news');
        return $result;
    }

    public function encodeNews()
    {
        $news = $this->getNews();
        $news = $news[0];
        $news_json = json_encode($news, JSON_PRETTY_PRINT);
        return $news_json;
    }

    public function putNews()
    {
        $fpath = '';
        $news_json = $this->encodeNews();
        file_put_contents($fpath, $news_json);
    }

    public function checkUid($user_id)
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
        if (!$this->checkUid($user_id)) {
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
