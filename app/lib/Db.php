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
     * @var \Exception
     */
    public static $exception;

    /**
     * @var array
     */
    public $config;

    /**
     * Singleton MySQL connection
     * @return Db
     */
    public static function init(): Db
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
     * Setup Db config
     * @param array $config
     * @return void
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * Connect and setup Db
     * @return void
     */
    public function setDb(): void
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // make the default fetch be an associative array
        ];
        $this->db = new PDO(
            'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['name'] . '',
            $this->config['user'],
            $this->config['password'],
            $options
        );
    }

    /**
     * Make custom query to Db with placeholders
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
     * Make row query to Db and return result
     * @param $sql
     * @param array $params
     * @return array
     */
    public function row($sql, $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Make column query to Db and return result
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
