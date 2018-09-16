<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\API;

/**
 * Class APITest
 */
class APITest extends TestCase
{
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
        $this->assertInternalType("array", $data);
        $this->assertInternalType("int", $data['id']);
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
}
