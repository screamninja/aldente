<?php

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
        $api = new API('tocken', $db);
        $data = [
            'id' => 1,
            'params' => 1,
            'method' => 1,
            'jsonrpc' => '2.0',
        ];
        $actual = $api->checkResponse($data);
        $this->assertTrue($actual);
        $data = [
            'id' => 1,
            'params' => 1,
            'method' => 1,
            'jsonrpc' => '1.0',
        ];
        $actual = $api->checkResponse($data);
        $this->assertFalse($actual);

        //

        $need = [123,321];
        $isit = [321,321];

        $this->assertEquals($need, $isit);

    }
}
