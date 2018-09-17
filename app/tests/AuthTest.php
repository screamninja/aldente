<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\Auth;

class AuthTest extends TestCase
{
    protected $stack_login;
    protected $stack_sign_up;
    protected $bad_stack;
    protected $data = array();
    protected $stmt = array();
    protected $auth;

    protected function setUp()
    {
        $this->stack_login = [
            'login' => 'test',
            'password' => 'test',
            'do_login' => '',
            ];
        $this->stack_sign_up = [
            'login' => 'testLogin',
            'email' => 'testEmail',
            'password' => 'testPassword',
            'password_2' => 'testPassword_2',
            'do_sign_up' => '',
        ];
        $this->bad_stack = [
            'login' => 'test',
            'password' => 'test',
            'do_login' => '',
        ];
        $this->stmt = [
            'password' => '$2y$10$FvKqntyZlJikpYxTdVhIve3dgcwxyCEE7Vl1jGkxX5eu6n/pqcKWi',
        ];
        $this->auth = new Auth($this->data);
    }

    public function testGetDataReturnArray()
    {
        $this->data = $this->stack_login;
        $actual = $this->auth->getData();
        $this->assertInternalType("array", $actual);
    }

    public function testCheckDataReturnEmptyArray()
    {
        $this->data = $this->stack_login;
        $actual = $this->auth->checkData();
        $this->assertEmpty($actual);
    }

    public function testCheckDataReturnErrorArray()
    {
        $this->data = $this->bad_stack;
        $actual = $this->auth->checkData();
        $this->assertNotEmpty($actual);
    }

    public function testCheckPasswordReturnTrue()
    {
        $this->data = $this->stack_login;
        $actual = $this->auth->checkPassword($this->stmt);
        $this->assertTrue($actual);
    }

    public function testCheckPasswordReturnFalse()
    {
        $this->data = $this->bad_stack;
        $actual = $this->auth->checkPassword($this->stmt);
        $this->assertFalse($actual);
    }
}
