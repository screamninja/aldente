<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class API
 * @package PFW\Models
 */
class API extends Model
{
    const DAY_COUNT = 100;

    /**
     * @var string
     */
    private $token;

    /**
     * API constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        parent::__construct();
        $this->token = $token;
    }

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
    public function checkCount(): bool
    {
        $stmt = $this->db->query(
            "SELECT daily_count FROM api
                 WHERE token = :token",
            $param = ['token' => $this->token]
        );
        $count = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]; //todo 1 значение
        $count = $count['daily_count'];
        if ($count <= self::DAY_COUNT) {
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

    /**
     * @param array $data
     * @return bool
     */
    public function checkResponse(array $data): bool
    {
        $correct = true;
        if (isset($data) && is_array($data)) {
            if ($data['jsonrpc'] != '2.0') {
                $correct = false;
            }
            if (empty($data['method'])) {
                $correct = false;
            }
            if (empty($data['params'])) {
                $correct = false;
            }
            if (empty($data['id']) && !is_integer($data['id'])) {
                $correct = false;
            }
        }
        return $correct;
    }

    /**
     * @param int $count
     * @return array
     */
    public function getNews(int $count): array
    {
        if ($this->checkToken()) {
            if ($this->checkCount()) {
                $result = $this->db->row('SELECT * FROM news LIMIT ' . $count);
                return $result['news'] = $result; //todo Заменить на что-оо общее тут и в рендере
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

    /**
     * @param $params
     * @return false|string
     */
    public function jsonNews($params): string
    {
        $news = $this->getNews($params);
        if (isset($news['error'])) {
            $response = $this->jsonError($news['error']); //todo fixme
            return $response;
        }
        $json = [
            'jsonrpc' => '2.0',
            'result' => $news,
            'id' => '1'
        ];
        return json_encode($json);
    }

    /**
     * @param $code
     * @param $message
     * @return false|string
     */
    public static function jsonError($code, $message) //todo
    {
        $json = [
            'jsonrpc' => '2.0',
            'code' => $code,
            'message' => $message,
            'id' => '1'
        ];
        $response = json_encode($json);
        return $response;
    }

    /**
     * @return array
     */
    public function addToken(): array
    {
        $login = $_SESSION['logged_user']; //todo по возможности  оогин передать как свойство метода
        $user_data = $this->db->row(
            "SELECT * FROM users
             WHERE login = :login",
            $param = ['login' => $login]
        );
        $user_data = $user_data[0]; //todo Проверить на существование
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
            if ($stmt) { //todo глянь что внутри
                $return = [
                    'uid' => $user_id,
                    'key' => $api_key
                ];
            } else {
                $return = ['error' => 'Something went wrong... Please contact with our support.'];
            }
        } else {
            $return = ['error' => 'User ' . $login . ' already got the Key!'];
        }
        return $return;
    }
}
