<?php

namespace PFW\Core;

use PFW\Lib\Db;

abstract class Model
{
    public $db;
    public $exception;

    public function __construct()
    {
        try {
            $this->db = new Db;
        } catch (\Throwable $exception) {
            $this->exception = $exception->getMessage();
        }
    }
}
