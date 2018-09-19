<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Lib\Db;
use PFW\Models\Main;

class MainTest extends TestCase
{
    protected $config;
    protected $db;

    protected function setUp()
    {
        $this->config = [

            'host' => 'localhost',
            'name' => 'pfw_test',
            'user' => 'test_admin',
            'password' => 'test_pass',
        ];
        $this->db = Db::init();
        $this->db->setConfig($this->config);
        $this->db->setDb();
    }

    public function testShowNews()
    {
        $param = [
            'title' => 'test title',
            'text' => 'test text',
            'author' => 'test author',
            'post_date' => 'test date',
        ];
        $this->db->query("INSERT INTO news (title, text, author, post_date)
                 VALUES (:title, :text, :author, :post_date)",
            $param
        );
        $main = new Main();
        $actual = $main->showNews();
        $actual = array_shift($actual);
        $this->assertEquals($param, $actual);
    }

    protected function tearDown()
    {
        $this->db->query("TRUNCATE TABLE news");
    }
}
