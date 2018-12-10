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
     * Show news from Db
     * @return array
     */
    public function showNews(): array
    {
        $db = Db::init();
        return $db->row('SELECT title, text, author, post_date FROM news');
    }
}
