<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\API;

/**
 * Class APITest
 */
class APITest extends TestCase
{
    protected $error;

    protected function setUp()
    {
        parent::setUp();
        $this->error = [''];
    }

    /**
     * @test
     */
    public function testCheckResponse()
    {
        $db = \PFW\Lib\Db::init();
        $api = new API('token', $db);
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

    public function testGetJson()
    {
        $stub = $this->getMockBuilder(API::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        // Configure the stub.
        $stub->method('getApiData')
            ->willReturn(['foo']);

        $db = \PFW\Lib\Db::init();
        $api = new API('token', $db);
        $api::getError($this->error)
            ->will($this->returnValue(''));

        $res = $stub->getJson(1);

        $this->assertEquals(['foo'], $res);
    }
}
