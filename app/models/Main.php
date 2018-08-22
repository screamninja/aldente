<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class Main
 * @package PFW\Models
 */
class Main extends Model
{

    /**
     * @return array
     */
    public function showNews(): array
    {
        $result = $this->db->row('SELECT title, text FROM news');
        return $result;
    }
}
