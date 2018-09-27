<?php

namespace PFW\Tests;

use PHPUnit\Framework\TestCase;
use PFW\Models\User;
use PFW\Lib\Db;

/**
 * Class UserTest
 * @package PFW\Tests
 */
class UserTest extends TestCase
{
    /**
     * @var Db
     */
    protected static $db;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var array with sign up data from a form
     */
    protected $data;
    /**
     * @var array with data for insert to Db users table
     */
    protected $usersParam;
    /**
     * @var array with data for insert to Db news table
     */
    protected $apiParam;

    /**
     * connect and setup test db
     */
    public static function setUpBeforeClass()
    {
        $config = [
            'host' => 'localhost',
            'name' => 'pfw_test',
            'user' => 'test_admin',
            'password' => 'test_pass',
        ];
        self::$db = Db::init();
        self::$db->setConfig($config);
        self::$db->setDb();
    }

    /**
     * set up fixtures
     */
    protected function setUp()
    {
        $this->user = new User(self::$db);
        $this->data = [
            'login' => 'test',
            'email' => 'test@test.com',
            'password' => 'test',
            'password_2' => 'test',
            'do_sign_up' => '',
        ];
        $this->usersParam = [
            'login' => 'test',
            'email' => 'test@test.com',
            'password' => '$2y$10$NGnZ3UAiN1kYMk5B0KtAGeeDLjlP2FfpPPywW0Z7PeEW9jMQRsi3S',
            'join_date' => 'Wed, 26 Sep 2018 20:40:36 +0300',
            'unix_timestamp' => '1537983636',
        ];
        $this->apiParam = [
            'user_id' => '59',
            'token' => '$2y$10$VUc2LGIKLWrvCeGPEBEDBucz/PZBjg89RbK.976D4.0feverU.u2K',
            'daily_count' => '42',
            'last_get' => '2018-09-26 20:41:49',
        ];
    }

    /**
     * @test
     */
    public function testIssetUser()
    {
        self::$db->query(
            "INSERT INTO users (login, email, password, join_date, unix_timestamp)
                 VALUES (:login, :email, :password, :join_date, :unix_timestamp)",
            $this->usersParam
        );
        $actual = $this->user->issetUser($this->data);
        $this->assertTrue(true, $actual);
    }

    /**
     * @test
     * @return bool
     */
    public function testIssetUserId()
    {
        self::$db->query(
            "INSERT INTO api (user_id, token, daily_count, last_get)
                 VALUES (:user_id, :token, :daily_count, :last_get)",
            $this->apiParam
        );
        $actual = $this->user->issetUserId('59');
        $this->assertTrue(true, $actual);
        return !$actual;
    }

    /**
     * @test
     */
    public function testGetUser()
    {
        self::$db->query(
            "INSERT INTO users (login, email, password, join_date, unix_timestamp)
                 VALUES (:login, :email, :password, :join_date, :unix_timestamp)",
            $this->usersParam
        );
        $actual = $this->user->getUser($this->data);
        $this->assertEquals($this->usersParam += ['id' => '1'], $actual);
    }

    /**
     * @test
     */
    public function testAddUser()
    {
        $actual = $this->user->addUser($this->data);
        $this->assertTrue(true, $actual);
    }

    /**
     * @test
     * @depends testIssetUserId
     */
    public function testAddApiToken()
    {
        self::$db->query(
            "INSERT INTO users (login, email, password, join_date, unix_timestamp)
                 VALUES (:login, :email, :password, :join_date, :unix_timestamp)",
            $this->usersParam
        );
        $actual = $this->user->addApiToken('test');
        $stmt = self::$db->row(
            "SELECT * FROM api
                 WHERE user_id = 1"
        );
        $stmt = array_shift($stmt);
        $token = [
            'token' => $stmt['token'],
        ];
        $this->assertEquals($token, $actual);
    }

    /**
     * tear down fixtures
     */
    protected function tearDown()
    {
        $this->data = null;
        self::$db->query("TRUNCATE TABLE users");
        self::$db->query("TRUNCATE TABLE api");
    }

    /**
     * disconnect db
     */
    public static function tearDownAfterClass()
    {
        self::$db = null;
    }
}
