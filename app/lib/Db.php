<?php

namespace PFW\Lib;

use PDO;
use PFW\Config\DatabaseConfig;
use PFW\Config\LoggerConfig;

/**
 * Class Db
 * @package PFW\Lib
 */
class Db
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var self
     */
    private static $obj;

    /**
     * @var
     */
    public static $exception;

    /**
     * @var
     */
    public $config;

    /**
     * @return Db
     */
    public static function init()
    {
        if (!self::$obj) {
            try {
                self::$obj = new self();
            } catch (\Throwable $e) {
                self::$exception = 'Something goes wrong...';
                $logger = LoggerConfig::getLogger();
                $logger->error($e->getMessage());
            }
        }
        return self::$obj;
    }

    /**
     * Db constructor.
     */
    private function __construct()
    {
        $this->setConfig(DatabaseConfig::get());
        $this->setDb();
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * connect and setup test db
     */
    public function setDb()
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        $this->db = new PDO(
            'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['name'] . '',
            $this->config['user'],
            $this->config['password'],
            $options
        );
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool|\PDOStatement
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
