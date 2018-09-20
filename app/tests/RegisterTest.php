<?php

namespace PFW\Tests;

use PFW\Models\Auth;
use PFW\Models\User;
use PHPUnit\Framework\TestCase;
use PFW\Models\Register;

class RegisterTest extends TestCase
{
    protected $data;

    protected function setUp()
    {
        $this->data = [
            'login' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
            'password_2' => 'test',
            'do_sign_up' => '',
        ];
    }

    public function testSignUp()
    {
        /*$stub = $this->getMockBuilder(Register::class)
            ->setMethods()
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $auth = $this->getMockBuilder(Auth::class)
            ->setMethods(['checkData'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $auth->method('checkData')
            ->willReturn(['']);

        $user = $this->getMockBuilder(User::class)
            ->setMethods(['issetUser', 'addUser'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $user->method('issetUser')
            ->willReturn(false);
        $user->method('addUser')
            ->willReturn(true);

        $actual = $stub->signUp();
        $this->assertEmpty($actual);*/









        /*$mock = $this->getMockBuilder(Register::class)
            ->setMethodsExcept(['checkData', 'issetUser', 'addUser'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects($this->once())
            ->method('checkData')
            ->willReturn(['']);
        $mock->expects($this->once())
            ->method('issetUser')
            ->willReturn(false);
        $mock->expects($this->once())
            ->method('addUser')
            ->willReturn(true);
        $actual = $mock->signUp();
        $this->assertEmpty($actual);*/









        $stub = $this->getMockBuilder(Register::class)
            ->setMethods(['checkData', 'issetUser', 'addUser'])
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
        $stub->method('checkData')
            ->willReturn(['errors' => '']);
        $stub->method('issetUser')
            ->willReturn(false);
        $stub->method('addUser')
            ->willReturn(true);

        $res = $stub->signUp();
        $this->assertEmpty($res);
    }
}
