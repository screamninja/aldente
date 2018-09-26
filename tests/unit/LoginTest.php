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
     * @var
     */
    protected $data;

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
        $_SESSION['logged_user'] = 'for_unset';
    }

    /**
     * @test
     */
    public function testLogin()
    {
        $login = new Login($this->data);

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

        $login->login($stubAuth, $stubUser);

        $actual = $_SESSION['logged_user'];
        $this->assertEquals('test', $actual);
    }

    /**
     * @test
     */
    public function testLoginReturnErrorWhenPasswordIsIncorrect()
    {
        $login = new Login($this->data);

        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);
        $stubAuth->expects($this->once())->method('checkPassword')->willReturn(false);

        $stubUser = $this->createMock(User::class);

        $actual = $login->login($stubAuth, $stubUser);

        $this->assertEquals(['Password is incorrect! Try again.'], $actual);
    }

    /**
     * @test
     */
    public function testLoginReturnErrorWhenUserNotFound()
    {
        $login = new Login($this->data);

        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('getUser')->willReturn([
            'error' => 'User not found!',
        ]);

        $actual = $login->login($stubAuth, $stubUser);

        $this->assertEquals(['Users with that login not found! Try again or sign up on this site.'], $actual);
    }

    /**
     *
     */
    protected function tearDown()
    {
        unset($_SESSION['logged_user']);
    }
}
