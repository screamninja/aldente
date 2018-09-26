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
     * @var
     */
    protected $token;
    /**
     * @var
     */
    protected $db;

    /**
     *
     */
    protected function setUp()
    {
        $this->token = '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y';
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
     * @return bool
     */
    public function testCheckToken()
    {
        $param = [
            'user_id' => '42',
            'token' => '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y',
            'daily_count' => '89',
            'last_get' => '2018-09-05 21:38:38',
        ];
        $this->db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $param
        );
        $api = new API($this->token, $this->db);

        $actual = $api->checkToken();
        $this->assertTrue(true, $actual);
        return $actual;
    }

    /**
     * @test
     * @return bool
     */
    public function testCheckCount()
    {
        $param = [
            'user_id' => '42',
            'token' => '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y',
            'daily_count' => '89',
            'last_get' => '2018-09-05 21:38:38',
        ];
        $this->db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $param
        );
        $api = new API($this->token, $this->db);

        $actual = $api->checkCount();
        $this->assertTrue(true, $actual);
        return $actual;
    }

    /**
     * @test
     */
    public function testCheckResponse()
    {
        $api = new API($this->token, $this->db);
        $data = [
            'jsonrpc' => '2.0',
            'method' => 1,
            'params' => 1,
            'id' => 1,
        ];
        $actual = $api->checkResponse($data);
        $this->assertTrue($actual);
        $data = [''];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
        $data = [
            'jsonrpc' => '1.0',
            'method' => 1,
            'params' => 1,
            'id' => 1,
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
        $data = [
            'jsonrpc' => '2.0',
            'method' => '',
            'params' => 1,
            'id' => 1,
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
        $data = [
            'jsonrpc' => '2.0',
            'method' => 1,
            'params' => '',
            'id' => 1,
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
        $data = [
            'jsonrpc' => '2.0',
            'method' => 1,
            'params' => 1,
            'id' => '',
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
        $data = [
            'jsonrpc' => '2.0',
            'method' => 1,
            'params' => 1,
            'id' => 'one',
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);
    }

    /**
     * @test
     * @depends testCheckToken
     * @depends testCheckCount
     */
    public function testGetApiData()
    {
        $param = [
            'user_id' => '42',
            'token' => '$2y$10$Vfx5pplJ1JnPorTFALk1yeFyU.sOf3t3GznPlmctxzChDC3hHxr6y',
            'daily_count' => '89',
            'last_get' => '2018-09-05 21:38:38',
        ];
        $this->db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $param
        );
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

        $api = new API($this->token, $this->db);

        $actual = $api->getApiData(1);
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

        $res = $stub->getJson(1);

        $this->assertEquals('{"jsonrpc":"2.0","result":["foo"],"id":"1"}', $res);
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->db->query("TRUNCATE TABLE api");
    }
}
