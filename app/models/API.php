<?php

namespace AlDente\Models;

use AlDente\Core\Model;
use AlDente\Lib\Db;

/**
 * Class API
 * @package AlDente\Models
 */
class API extends Model
{

    /**
     * Daily query limit
     */
    protected const DAY_COUNT = 100;

    /**
     * @var string
     */
    private $token;
    /**
     * @var Db
     */
    private $db;

    /**
     * API constructor.
     * @param string $token
     * @param Db $db
     */
    public function __construct(string $token, Db $db)
    {
        $this->token = $token;
        $this->db = $db;
    }

    /**
     * Check out API token from request header
     * @return bool
     */
    public function checkToken(): bool
    {
        $stmt = $this->db->query(
            'SELECT COUNT(*) FROM api
                 WHERE token = :token',
            $param = ['token' => $this->token]
        );
        $check_token = $stmt->fetchColumn();
        if ($check_token) {
            return true;
        }
        return false;
    }

    /**
     * Check count of API requests by token in Db
     * if constant of daily request limit not exceed return true
     * else if daily count exceeds more than a day ago, reset count and return true
     * else return false
     * @throws \Exception
     * @return bool
     */
    public function checkCount(): bool
    {
        $count = $this->db->column(
            'SELECT daily_count FROM api
                 WHERE token = :token',
            $param = ['token' => $this->token]
        );
        if ($count <= self::DAY_COUNT) {
            $this->db->query(
                'UPDATE api SET daily_count=:daily_count, last_get=NOW()
                 WHERE token = :token',
                $param = [
                    'token' => $this->token,
                    'daily_count' => ++$count,
                ]
            );
            return true;
        } else {
            $stmt = $this->db->column(
                'SELECT last_get
                     FROM api
                     WHERE token=:token',
                $param = ['token' => $this->token]
            );
            $last_get = new \DateTime($stmt);
            $date_now = new \DateTime('now');
            $interval = $last_get->diff($date_now);
            $days = $interval->format('%a');
            if ($days > 0) {
                $this->db->query(
                    'UPDATE api SET daily_count=1, last_get=NOW()
                          WHERE token = :token',
                    $param = ['token' => $this->token]
                );
                return true;
            }
            return false;
        }
    }

    /**
     * Check out body of API request
     * @param array $data
     * @return bool
     */
    public function checkRequest(array $data): bool
    {
        $correct = true;
        if ($data !== null && \is_array($data)) {
            if (empty($data['jsonrpc']) || $data['jsonrpc'] !== '2.0') {
                $correct = false;
            }
            if (empty($data['method'])) {
                $correct = false;
            }
            if (empty($data['params'])) {
                $correct = false;
            }
            if (empty($data['id']) || !\is_int($data['id'])) {
                $correct = false;
            }
        }
        return $correct;
    }

    /**
     * Check API token from request header, check daily request count and return API data
     * with the count parameter set in the request
     * @throws \Exception
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
     * Set and return body for JSON response
     * @throws \Exception
     * @param $params
     * @return false|string
     */
    public function getJson(int $params): string
    {
        $news = $this->getApiData($params);
        if (isset($news['error'])) {
            return self::getError($news['error']);
        }
        $json = [
            'jsonrpc' => '2.0',
            'result' => $news,
            'id' => '1',
        ];
        return json_encode($json);
    }

    /**
     * Set and return body for error response
     * @param array $error
     * @return false|string
     */
    public static function getError(array $error)
    {
        $json = [
            'jsonrpc' => '2.0',
            'error' => [$error],
            'id' => '1',
        ];
        return json_encode($json);
    }
}
