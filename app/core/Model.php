<?php

namespace PFW\Core;

use PFW\Config\LoggerConfig;
use PFW\Lib\Db;

/**
 * Class Model
 * @package PFW\Core
 */
abstract class Model
{
    /**
     * @var Db
     */
    public $db;
    /**
     * @var string
     */
    public $exception;

    /**
     * Model constructor.
     */
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
