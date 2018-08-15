<?php

namespace PFW\Lib\Routes;

use PFW\Lib\LoggerRoute;
use PFW\Lib\Db;

class DbRoute extends LoggerRoute
{
    public $db;
    public $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->db = new Db();
    }

    public function log($level, $message, array $context = [])
    {
        $param = [
            ':date' => $this->getDate(),
            ':level' => $level,
            ':message' => $message,
            ':context' => $this->contextStringify($context)
        ];
        $stmt = $this->db->query(
            'INSERT INTO ' . $this->table . ' (date, level, message, context) ' .
            'VALUES (:date, :level, :message, :context)',
            $param
        );
        return $stmt;
    }
}
