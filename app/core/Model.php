<?php

namespace PFW\Core;

use PFW\Lib\Db;

abstract class Model
{
    public $db;

    public function __construct()
    {
        $this->db = new Db;
    }
}