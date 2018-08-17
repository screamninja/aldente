<?php

namespace PFW\Models;

use PFW\Core\Model;

class API extends Model
{
    public function getNews(): array
    {
        $result = $this->db->row('SELECT title, text FROM news');
        return $result;
    }

    public function encodeNews()
    {
        $news_json = json_encode($this->getNews());
        return $news_json;
    }
}
