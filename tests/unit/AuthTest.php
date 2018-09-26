<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\Auth;

/**
 * Class AuthTest
 * @package PFW\Tests
 */
class AuthTest extends TestCase
{
    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $bad_data;
    /**
     * @var
     */
    protected $stmt;
    /**
     * @var
     */
    protected $bad_stmt;

    /**
     *
     */
    protected function setUp()
    {
        $this->data = [
            'login' => 'test',
            'password' => 'test',
            'do_login' => '',
        ];
        $this->bad_data = [
            'login' => '',
            'password' => 'test',
            'do_login' => '',
        ];
        $this->stmt = [
            'password' => '$2y$10$FvKqntyZlJikpYxTdVhIve3dgcwxyCEE7Vl1jGkxX5eu6n/pqcKWi',
        ];
        $this->bad_stmt = [
            'password' => '$2y$10$4zNZIeQj7SofHU989A3BUOni9Hk7jo7Ua4pKXK2VGI/MR9P7r3..i',
        ];
    }

    /**
     * @test
     */
    public function testGetDataReturnArray()
    {
        $auth = new Auth($this->data);
        $actual = $auth->getData();
        $this->assertInternalType("array", $actual);
    }

    /**
     * @test
     */
    public function testCheckDataReturnEmptyArray()
    {
        $auth = new Auth($this->data);
        $actual = $auth->checkData();
        $this->assertEmpty($actual);
    }

    /**
     * @test
     */
    public function testCheckDataReturnErrorArray()
    {
        $auth = new Auth($this->bad_data);
        $actual = $auth->checkData();
        $this->assertEquals(['Login is required'], $actual);
    }

    /**
     * @test
     */
    public function testCheckPasswordReturnTrue()
    {
        $auth = new Auth($this->data);
        $actual = $auth->checkPassword($this->stmt);
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function testCheckPasswordReturnFalse()
    {
        $auth = new Auth($this->data);
        $actual = $auth->checkPassword($this->bad_stmt);
        $this->assertFalse($actual);
    }
}
