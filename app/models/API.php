<?php

namespace PFW\Models;

use PFW\Core\Model;

class API extends Model
{
    private $token;

    public function __construct(string $token)
    {
        parent::__construct();
        $this->token = $token;
    }

    public function checkToken(): bool
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM api
                 WHERE token = :token",
            $param = ['token' => $this->token]
        );
        $check_token = $stmt->fetchColumn();
        if ($check_token) {
            return true;
        }
        return false;
    }

    public function checkCount(): bool
    {
        $stmt = $this->db->query(
            "SELECT daily_count FROM api
                 WHERE token = :token",
            $param = ['token' => $this->token]
        );
        $count = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
        $count = $count['daily_count'];
        if ($count <= 100) {
            $this->db->query(
                "UPDATE api SET daily_count=:daily_count, last_get=NOW()
                 WHERE token = :token",
                $param = [
                    'token' => $this->token,
                    'daily_count' => ++$count
                ]
            );
            return true;
        } else {
            $stmt = $this->db->column(
                "SELECT last_get
                     FROM api
                     WHERE token=:token",
                $param = ['token' => $this->token]
            );
            $last_get = new \DateTime($stmt);
            $date_now = new \DateTime('now');
            $interval = $last_get->diff($date_now);
            $days = $interval->format('%a');
            if ($days > 0) {
                $this->db->query(
                    "UPDATE api SET daily_count=1, last_get=NOW()
                          WHERE token = :token",
                    $param = ['token' => $this->token]
                );
                return true;
            }
            return false;
        }
    }

    public function getNews(int $count): array
    {
        if ($this->checkToken()) {
            if ($this->checkCount()) {
                $result = $this->db->row('SELECT * FROM news LIMIT ' . $count);
                return $result['news'] = $result;
            }
            return $result['error'] = [
                'code' => '-32500',
                'message' => 'The number of allowed requests (100) is exceeded'
            ];
        } else {
            return $result['error'] = [
                'code' => '-32500',
                'message' => 'Invalid Token'
            ];
        }
    }

    public function jsonNews($params)
    {
        $news = $this->getNews($params);
        if (isset($news['error'])) {
            $response = $this->jsonError($news['error']);
            return $response;
        }
        $json = [
            'jsonrpc' => '2.0',
            'result' => $news,
            'id' => '1'
        ];
        $response = json_encode($json);
        return $response;
    }

    public function jsonError($error)
    {
        $json = [
            'jsonrpc' => '2.0',
            'message' => array($error),
            'id' => '1'
        ];
        $response = json_encode($json);
        return $response;
    }

    public function addToken()
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
        $user = new User();
        if (!$user->issetUserId($user_id)) {
            $stmt = $this->db->query(
                "INSERT INTO api (user_id, token, last_get)
             VALUES (:user_id, :api_key, NOW())",
                $param = [
                    'user_id' => $user_id,
                    'api_key' => $api_key
                ]
            );
            if ($stmt) {
                return $api_data = [
                    'uid' => $user_id,
                    'key' => $api_key
                ];
            }
            return $error = ['error' => 'Something went wrong... Please contact with our support.'];
        }
        return $error = ['error' => 'User ' . $login . ' already got the Key!'];
    }
}
