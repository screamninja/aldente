<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Lib\Db;
use PFW\Models\Main;

/**
 * Class MainTest
 * @package PFW\Tests
 */
class MainTest extends TestCase
{
    /**
     * @var
     */
    protected $db;

    /**
     *
     */
    protected function setUp()
    {
        $config = [

            'host' => 'localhost',
            'name' => 'pfw_test',
            'user' => 'test_admin',
            'password' => 'test_pass',
        ];
        $this->db = Db::init();
        $this->db->setConfig($config);
        $this->db->setDb();
    }

    /**
     * @test
     */
    public function testShowNews()
    {
        $param = [
            'title' => 'test title',
            'text' => 'test text',
            'author' => 'test author',
            'post_date' => 'test date',
        ];
        $this->db->query(
            "INSERT INTO news (title, text, author, post_date)
                 VALUES (:title, :text, :author, :post_date)",
            $param
        );
        $main = new Main();
        $actual = $main->showNews();
        $actual = array_shift($actual);
        $this->assertEquals($param, $actual);
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->db->query("TRUNCATE TABLE news");
    }
}
