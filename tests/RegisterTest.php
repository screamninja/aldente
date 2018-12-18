<?php

namespace AlDente\Tests;

use PHPUnit\Framework\TestCase;
use AlDente\Models\Register;
use AlDente\Models\Auth;
use AlDente\Models\User;

/**
 * Class RegisterTest
 * @package AlDente\Tests
 */
class RegisterTest extends TestCase
{
    /**
     * @var array with sign up data from a form
     */
    protected $data;
    /**
     * @var Register
     */
    protected $register;

    /**
     * set up fixtures
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
        $this->register = new Register($this->data);
    }

    /**
     * @test
     */
    public function testSignUpReturnArrayWithLoginWhenUserAdded()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(false);
        $stubUser->expects($this->once())->method('addUser')->willReturn(true);

        $actual = $this->register->signUp($stubAuth, $stubUser);
        $this->assertEquals(['user' => $this->data['login']], $actual);
    }

    /**
     * @test
     */
    public function testSignUpReturnErrorWhenUserIsset()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(true);

        $actual = $this->register->signUp($stubAuth, $stubUser);
        $this->assertEquals(['error' => 'An account already exists with this login or email address.'], $actual);
    }

    /**
     * @test
     */
    public function testSignUpReturnErrorWhenUserDidntAdd()
    {
        $stubAuth = $this->createMock(Auth::class);
        $stubAuth->expects($this->once())->method('checkData')->willReturn([]);

        $stubUser = $this->createMock(User::class);
        $stubUser->expects($this->once())->method('issetUser')->willReturn(false);
        $stubUser->expects($this->once())->method('addUser')->willReturn(false);

        $actual = $this->register->signUp($stubAuth, $stubUser);
        $this->assertEquals(['error' => 'User didn\'t to add'], $actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        $this->data = null;
        $this->register = null;
    }
}
