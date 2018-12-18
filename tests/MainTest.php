<?php

namespace AlDente\Tests;

use PHPUnit\Framework\TestCase;
use AlDente\Lib\Db;
use AlDente\Models\Main;

/**
 * Class MainTest
 * @package AlDente\Tests
 */
class MainTest extends TestCase
{
    /**
     * @var Db
     */
    protected static $db;
    /**
     * @var Main
     */
    protected $main;
    /**
     * @var array with data for insert to Db news table
     */
    protected $param;

    /**
     * connect and setup test db
     */
    public static function setUpBeforeClass()
    {
        $config = [
            'host' => 'localhost',
            'name' => 'AlDente_test',
            'user' => 'test_admin',
            'password' => 'test_pass',
        ];
        self::$db = Db::init();
        self::$db->setConfig($config);
        self::$db->setDb();
    }

    /**
     * set up fixtures
     */
    protected function setUp()
    {
        $this->main = new Main();
        $this->param = [
            'title' => 'test title',
            'text' => 'test text',
            'author' => 'test author',
            'post_date' => 'test date',
        ];
    }

    /**
     * @test
     */
    public function testShowNews()
    {
        self::$db->query(
            "INSERT INTO news (title, text, author, post_date)
                 VALUES (:title, :text, :author, :post_date)",
            $this->param
        );
        $actual = $this->main->showNews();
        $actual = array_shift($actual);
        $this->assertEquals($this->param, $actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        self::$db->query("TRUNCATE TABLE news");
        $this->main = null;
        $this->param = null;
    }

    /**
     * disconnect db
     */
    public static function tearDownAfterClass()
    {
        self::$db = null;
    }
}
