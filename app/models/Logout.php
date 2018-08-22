<?php

namespace PFW\Models;

use PFW\Core\Model;

/**
 * Class Logout
 * @package PFW\Models
 */
class Logout extends Model
{
    /**
     * @var array
     */
    public $data;

    /**
     * Logout constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getLogOutData(): array
    {
        return $this->data;
    }
}
