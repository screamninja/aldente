<?php

namespace AlDente\Models;

use AlDente\Core\Model;
use AlDente\Lib\Db;

/**
 * Class Main
 * @package AlDente\Models
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
