<?php

namespace PFW\Tests;

use PFW\Models\Auth;
use PFW\Models\Register;
use PFW\Models\User;
use PHPUnit\Framework\TestCase;
use PFW\Models\Login;

class LoginTest extends TestCase
{
    protected $data;

    protected function setUp()
    {
        $this->data = [
            'login' => 'test',
            'password' => 'test',
            'do_login' => '',
        ];
    }

    public function testLogin()
    {
        $auth = $this->getMockBuilder(Auth::class)
            ->setMethods(['checkData', 'checkPassword'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $auth->expects($this->any())
            ->method('checkData')
            ->willReturn(['']);
        $auth->expects($this->any())
            ->method('checkPassword')
            ->willReturn(true);

        $user = $this->getMockBuilder(User::class)
            ->setMethods(['getUser'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $user->expects($this->any())
            ->method('getUser')
            ->willReturn([
                'id' => '256',
                'login' => 'test',
                'email' => 'test@test.com',
                'password' => '$2y$10$FvKqntyZlJikpYxTdVhIve3dgcwxyCEE7Vl1jGkxX5eu6n/pqcKWi',
                'join_date' => 'Mon, 17 Sep 2018 23:18:55 +0300',
                'unix_timestamp' => '1537215535',
            ]);

        /*$login = new Login($this->data);
        $login->login();*/

        $mock = $this->getMockBuilder(Login::class)
            ->setMethods()
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $mock->login();

        $actual = $_SESSION['logged_user'];
        $this->assertEquals('test', $actual);
    }

    protected function tearDown()
    {
        unset($_SESSION['logged_user']);
    }
}
