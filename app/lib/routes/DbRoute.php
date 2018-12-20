<?php

namespace AlDente\Lib\Routes;

use AlDente\Lib\LoggerRoute;
use AlDente\Lib\Db;

/**
 * Class DbRoute
 * @package AlDente\Lib\Routes
 */
class DbRoute extends LoggerRoute
{
    /**
     * @var Db
     */
    public $db;
    /**
     * @var mixed
     */
    public $table;

    /**
     * DbRoute constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->db = Db::init();
        $this->table = $attributes['table'];
    }

    /**
     * Add log in to Db in table logs
     * @param mixed $level
     * @param string $message
     * @param mixed $context
     * @throws \Exception
     * @return bool|void
     */
    public function log($level, $message, array $context = [])
    {
        if ($this->contextStringify($context) === null) {
            $context = 'none';
        }
        $param = [
            'date' => $this->getDate(),
            'level' => $level,
            'message' => $message,
            'context' => $context,
        ];
        $this->db->query(
            'INSERT INTO logs (date, level, message, context)
                  VALUES (:date, :level, :message, :context)',
            $param
        );
    }
}
