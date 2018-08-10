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
}
