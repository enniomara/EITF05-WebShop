<?php

namespace Tests\Unit;

use App\Classes\DAO\UserMySQLDAO;
use App\Classes\PasswordService;
use App\Classes\UserService;
use App\Interfaces\DAO\UserDAO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @var UserDAO|MockObject
     */
    private $userDAOStub;
    /**
     * @var UserService
     */
    private $userService;

    protected function setUp()
    {
        parent::setUp();
        $this->userDAOStub = $this->getMockBuilder(UserMySQLDAO::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->userService = new UserService($this->userDAOStub);
    }

    public function testLogin()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findByUsernameAndPassword')
            ->willReturn([
                [
                    'username' => 'test'
                ]
            ]);

        $response = $this->userService->login('username', 'password');
        $this->assertTrue($response);
    }

    public function testLoginWithIncorrectAuthentication()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findByUsernameAndPassword')
            ->willReturn([]);

        $this->expectException(\InvalidArgumentException::class);
        $this->userService->login('username', 'password');
    }

    public function testCreate() {
        $username = 'username';
        $password = 'password';
        $address = 'Lund';
        $hashedPassword = PasswordService::hash($password);

        $this->userDAOStub->expects($this->once())
            ->method('create')
            ->with($username, $hashedPassword, $address)
            ->willReturn($username);

        $returnValue = [$username];
        $this->userDAOStub->expects($this->once())
            ->method('findByUsernameAndPassword')
            ->with($username, $hashedPassword)
            ->willReturn($returnValue);

        $response = $this->userService->create($username, $password, $address);
        // Assert that the value is returned is the value retrieved from findByUsernameAndPassword
        $this->assertEquals($returnValue, $response);
    }
}
