<?php

namespace PFW\Core;

use PFW\Config\LoggerConfig;
use PFW\Lib\Db;

abstract class Model
{
    public $db;
    public $exception;

    public function __construct()
    {
        try {
            $this->db = new Db();
        } catch (\Throwable $e) {
            $this->exception = 'Something goes wrong...';
            $logger = LoggerConfig::getLogger();
            $logger->error($e->getMessage());
        }
    }
}
