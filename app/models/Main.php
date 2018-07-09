<?php

namespace PFW\Models;

use PFW\Core\Model;

class Main extends Model
{
    public function getTicker()
    {
        var_dump($this->db);
    }
}