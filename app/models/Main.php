<?php

namespace PFW\Models;

use PFW\Core\Model;

class Main extends Model
{
    public function getNews()
    {
        $result = $this->db->row('SELECT title, text FROM news');
        return $result;
    }
}