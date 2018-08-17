<?php

namespace PFW\Models;

use PFW\Core\Model;

class Main extends Model
{
    public $api;

    public function showNews(): array
    {
        $this->api = new API();
        $news = $this->api->getNews();
        return $news;
    }
}
