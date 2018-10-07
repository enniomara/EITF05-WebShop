<?php

namespace Tests\Unit;

use App\Classes\DAO\UserMySQLDAO;
use App\Classes\Models\User;
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
    /**
     * @var User
     */
    private $userModel;

    protected function setUp()
    {
        parent::setUp();
        $this->userDAOStub = $this->getMockBuilder(UserMySQLDAO::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->userService = new UserService($this->userDAOStub);
        $this->userModel = new User("username", "password", "Address");
    }

    public function testLogin()
    {
        $hashedPassword = PasswordService::hash($this->userModel->getPassword());
        // Assert that the hashed password is used when searching in db
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsernameAndPassword')
            ->with($this->userModel->getUsername(), $hashedPassword)
            ->willReturn($this->userModel);

        $response = $this->userService->login($this->userModel->getUsername(), $this->userModel->getPassword());
        $this->assertTrue($response);
    }

    public function testLoginWithIncorrectAuthentication()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsernameAndPassword')
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->userService->login('username', 'password');
    }

    public function testCreate()
    {
        $username = $this->userModel->getUsername();
        $password = $this->userModel->getPassword();
        $address = $this->userModel->getAddress();
        $hashedPassword = PasswordService::hash($password);

        $this->userDAOStub->expects($this->once())
            ->method('create')
            ->with($username, $hashedPassword, $address)
            ->willReturn($username);

        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsernameAndPassword')
            ->with($username, $hashedPassword)
            ->willReturn($this->userModel);

        $response = $this->userService->create($username, $password, $address);
        // Assert that the value is returned is the value retrieved from findByUsernameAndPassword
        $this->assertEquals($this->userModel, $response);
    }
}
