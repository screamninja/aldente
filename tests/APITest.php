<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\API;
use PFW\Lib\Db;

/**
 * Class APITest
 */
class APITest extends TestCase
{
    /**
     * @var Db
     */
    protected static $db;
    /**
     * @var string
     */
    protected $token;
    /**
     * @var API
     */
    protected $api;
    /**
     * @var array with data for insert to Db
     */
    protected $param;
    /**
     * @var array with data in JSON format
     */
    protected $data;

    /**
     * connect and setup test db
     */
    public static function setUpBeforeClass()
    {
        $config = [
            'host' => 'localhost',
            'name' => 'pfw_test',
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
        $this->token = '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y';
        $this->api = new API($this->token, self::$db);
        $this->param = [
            'user_id' => '42',
            'token' => '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y',
            'daily_count' => '89',
            'last_get' => '2018-09-05 21:38:38',
        ];
        $this->data = [
            'jsonrpc' => '2.0',
            'method' => 1,
            'params' => 1,
            'id' => 1,
        ];
    }

    /**
     * @test
     * @return bool
     */
    public function testCheckTokenIsValid()
    {
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $this->param
        );
        $actual = $this->api->checkToken();
        $this->assertTrue(true, $actual);
        return $actual;
    }

    /**
     * @test
     */
    public function testCheckTokenInvalid()
    {
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $this->param
        );
        $actual = $this->api->checkToken();
        $this->assertFalse(false, $actual);
    }

    /**
     * @test
     * @return bool
     */
    public function testCheckCountIsValid()
    {
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $this->param
        );
        $actual = $this->api->checkCount();
        $this->assertTrue(true, $actual);
        return $actual;
    }

    /**
     * @test
     */
    public function testCheckCountInvalid()
    {
        $this->param['daily_count'] = '101';
        unset($this->param['last_get']);
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, NOW())",
            $this->param
        );
        $actual = $this->api->checkCount();
        $this->assertFalse(false, $actual);
    }

    /**
     * @test
     */
    public function testCheckRequestIsValid()
    {
        $actual = $this->api->checkRequest($this->data);
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenBodyIsEmpty()
    {
        $this->data = [''];
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenJsonVersionInvalid()
    {
        $this->data['jsonrpc'] = '1.0';
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenMethodIsEmpty()
    {
        $this->data['method'] = '';
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenParamsIsEmpty()
    {
        $this->data['params'] = '';
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenIdIsEmpty()
    {
        $this->data['id'] = '';
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function testCheckRequestReturnFalseWhenIdIsNotInteger()
    {
        $this->data['id'] = 'one';
        $actual = $this->api->checkRequest($this->data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     * @depends testCheckTokenIsValid
     * @depends testCheckCountIsValid
     */
    public function testGetApiData()
    {
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $this->param
        );
        $param = [
            'title' => 'test title',
            'text' => 'test text',
            'author' => 'test author',
            'post_date' => 'test date',
        ];
        self::$db->query(
            "INSERT INTO news (title, text, author, post_date)
                 VALUES (:title, :text, :author, :post_date)",
            $param
        );
        $actual = $this->api->getApiData(1);
        $actual = array_shift($actual);
        $this->assertEquals($param += ['id' => '1'], $actual);
    }

    /**
     * @test
     */
    public function testGetJson()
    {
        $stub = $this->getMockBuilder(API::class)
            ->setMethods(['getApiData'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $stub->method('getApiData')
            ->willReturn(['foo']);

        $actual = $stub->getJson(1);

        $this->assertEquals('{"jsonrpc":"2.0","result":["foo"],"id":"1"}', $actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        self::$db->query("TRUNCATE TABLE api");
        self::$db->query("TRUNCATE TABLE news");
        $this->token = null;
        $this->api = null;
    }

    /**
     * disconnect db
     */
    public static function tearDownAfterClass()
    {
        self::$db = null;
    }
}
