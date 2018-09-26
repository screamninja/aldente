<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\Register;
use PFW\Models\Auth;
use PFW\Models\User;

/**
 * Class RegisterTest
 * @package PFW\Tests
 */
class RegisterTest extends TestCase
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
            'email' => 'test@test.com',
            'password' => 'test',
            'password_2' => 'test',
            'do_sign_up' => '',
        ];
    }

    /**
     * @test
     */
    public function testSignUp()
    {
        $register = new Register($this->data);

        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(false);
        $stubUser->expects($this->once())->method('addUser')->willReturn(true);

        $actual = $register->signUp($stubAuth, $stubUser);
        $this->assertEquals([], $actual);
    }

    /**
     * @test
     */
    public function testSignUpReturnErrorWhenUserIsSet()
    {
        $register = new Register($this->data);

        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(true);

        $actual = $register->signUp($stubAuth, $stubUser);
        $this->assertEquals(['An account already exists with this login or email address.'], $actual);
    }

    /**
     * @test
     */
    public function testSignUpReturnErrorWhenUserDidntAdd()
    {
        $register = new Register($this->data);

        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(false);
        $stubUser->expects($this->once())->method('addUser')->willReturn(false);

        $actual = $register->signUp($stubAuth, $stubUser);
        $this->assertEquals(['User didn\'t to add'], $actual);
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->data = null;
    }
}
