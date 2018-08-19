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
        $this->table = $attributes['table'];
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return bool|void
     */
    public function log($level, $message, array $context = [])
    {
        if ($this->contextStringify($context) == null) {
            $context = 'none';
        }
        $param = [
            'date' => $this->getDate(),
            'level' => $level,
            'message' => $message,
            'context' => $context,
        ];
        $this->db->query(
            "INSERT INTO logs (date, level, message, context)
                  VALUES (:date, :level, :message, :context)",
            $param
        );
    }
}
