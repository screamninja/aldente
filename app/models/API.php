<?php

namespace PFW\Models;

use PFW\Core\Model;
use PFW\Lib\Db;

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
    private $db;

    /**
     * API constructor.
     * @param string $token
     * @param Db $db
     */
    public function __construct(string $token, Db $db)
    {
        //parent::__construct();
        $this->token = $token;
        $this->db = $db;
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
        $stmt = $this->db->column(
            "SELECT daily_count FROM api
                 WHERE token = :token",
            $param = ['token' => $this->token]
        );
        $count = array_shift($stmt);
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
            if (empty($data['jsonrpc']) || $data['jsonrpc'] != '2.0') {
                $correct = false;
            }
            if (empty($data['method'])) {
                $correct = false;
            }
            if (empty($data['params'])) {
                $correct = false;
            }
            if (empty($data['id']) || !is_integer($data['id'])) {
                $correct = false;
            }
        }
        return $correct;
    }

    /**
     * @param int $count
     * @return array
     */
    public function getApiData(int $count): array
    {
        if ($this->checkToken()) {
            if ($this->checkCount()) {
                $result = $this->db->row('SELECT * FROM news LIMIT ' . $count);
                return $result['api_data'] = $result;
            }
            return $result['error'] = [
                'code' => '-32500',
                'message' => 'The number of allowed requests (100) is exceeded',
            ];
        } else {
            return $result['error'] = [
                'code' => '-32500',
                'message' => 'Invalid Token',
            ];
        }
    }

    /**
     * @param $params
     * @return false|string
     */
    public function getJson($params): string
    {
        $news = $this->getApiData($params);
        if (isset($news['error'])) {
            $response = $this->getError($news['error']);
            return $response;
        }
        $json = [
            'jsonrpc' => '2.0',
            'result' => $news,
            'id' => '1',
        ];
        return json_encode($json);
    }

    /**
     * @param $error
     * @return false|string
     */
    public static function getError($error)
    {
        $json = [
            'jsonrpc' => '2.0',
            'error' => array($error),
            'id' => '1',
        ];
        $response = json_encode($json);
        return $response;
    }
}
