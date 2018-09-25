<?php

namespace PFW\Models;

use PFW\Core\Model;
use PFW\Lib\Db;

/**
 * Class Main
 * @package PFW\Models
 */
class Main extends Model
{
    /**
     * @return array with news from DB
     */
    public function showNews(): array
    {
        $db = Db::init();
        $result = $db->row('SELECT title, text, author, post_date FROM news');
        return $result;
    }
}
