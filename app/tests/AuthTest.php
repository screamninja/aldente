<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\Auth;

class AuthTest extends TestCase
{
    protected $login_data;
    protected $sign_up_data;
    protected $bad_data;
    protected $data;
    protected $stmt;
    protected $bad_stmt;
    protected $auth;

    protected function setUp()
    {
        $this->login_data = [
            'login' => 'test',
            'password' => 'test',
            'do_login' => '',
            ];
        $this->sign_up_data = [
            'login' => 'testLogin',
            'email' => 'testEmail',
            'password' => 'testPassword',
            'password_2' => 'testPassword_2',
            'do_sign_up' => '',
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

    public function testGetDataReturnArray()
    {
        $this->auth = new Auth($this->login_data);
        $actual = $this->auth->getData();
        $this->assertInternalType("array", $actual);
    }

    public function testCheckDataReturnEmptyArray()
    {
        $this->auth = new Auth($this->login_data);
        $actual = $this->auth->checkData();
        $this->assertEmpty($actual);
    }

    public function testCheckDataReturnErrorArray()
    {
        $this->auth = new Auth($this->bad_data);
        $actual = $this->auth->checkData();
        $this->assertNotEmpty($actual);
    }

    public function testCheckPasswordReturnTrue()
    {
        $this->auth = new Auth($this->login_data);
        $actual = $this->auth->checkPassword($this->stmt);
        $this->assertTrue($actual);
    }

    public function testCheckPasswordReturnFalse()
    {
        $this->data = $this->login_data;
        $this->auth = new Auth($this->data);
        $actual = $this->auth->checkPassword($this->bad_stmt);
        $this->assertFalse($actual);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->data = null;
        $this->auth = null;
    }
}
