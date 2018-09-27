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
     * @var array with login data from a form
     */
    protected $data;
    /**
     * @var array with incorrect login data from a form
     */
    protected $bad_data;
    /**
     * @var array with valid password hash
     */
    protected $hash;
    /**
     * @var array with invalid password hash
     */
    protected $bda_hash;

    /**
     * set up fixtures
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
        $this->hash = [
            'password' => '$2y$10$FvKqntyZlJikpYxTdVhIve3dgcwxyCEE7Vl1jGkxX5eu6n/pqcKWi',
        ];
        $this->bda_hash = [
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
    public function testCheckPasswordIsValid()
    {
        $auth = new Auth($this->data);
        $actual = $auth->checkPassword($this->hash);
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function testCheckPasswordInvalid()
    {
        $auth = new Auth($this->data);
        $actual = $auth->checkPassword($this->bda_hash);
        $this->assertFalse($actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        $this->data = null;
        $this->bad_data = null;
        $this->hash = null;
        $this->bda_hash = null;
    }
}
