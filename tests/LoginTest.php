<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\Login;
use PFW\Models\Auth;
use PFW\Models\User;

/**
 * Class LoginTest
 * @package PFW\Tests
 */
class LoginTest extends TestCase
{
    /**
     * @var array with login data from a form
     */
    protected $data;
    /**
     * @var Login
     */
    protected $login;

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
        $this->login = new Login($this->data);
    }

    /**
     * @test
     */
    public function testLogin()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);
        $stubAuth->expects($this->once())->method('checkPassword')->willReturn(true);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('getUser')->willReturn([
            'id' => '256',
            'login' => 'test',
            'email' => 'test@test.com',
            'password' => '$2y$10$FvKqntyZlJikpYxTdVhIve3dgcwxyCEE7Vl1jGkxX5eu6n/pqcKWi',
            'join_date' => 'Mon, 17 Sep 2018 23:18:55 +0300',
            'unix_timestamp' => '1537215535',
        ]);

        $this->login->login($stubAuth, $stubUser);
        $this->assertEquals('test', $_SESSION['logged_user']);
        unset($_SESSION['logged_user']);
    }

    /**
     * @test
     */
    public function testLoginReturnErrorWhenPasswordIsIncorrect()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);
        $stubAuth->expects($this->once())->method('checkPassword')->willReturn(false);

        $stubUser = $this->createMock(User::class);

        $actual = $this->login->login($stubAuth, $stubUser);

        $this->assertEquals(['error' => 'Password is incorrect! Try again.'], $actual);
    }

    /**
     * @test
     */
    public function testLoginReturnErrorWhenUserNotFound()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('getUser')->willReturn([
            'error' => 'User not found!',
        ]);

        $actual = $this->login->login($stubAuth, $stubUser);

        $this->assertEquals([
            'error' => 'Users with that login not found! Try again or sign up on this site.',
        ], $actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        $this->login = null;
        $this->data = null;
    }
}
