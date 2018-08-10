<?php

namespace PFW\Models;

use PFW\Core\Model;

class Logout extends Model
{
    public $data;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public function getLogOutData(): array
    {
        return $this->data;
    }
}
