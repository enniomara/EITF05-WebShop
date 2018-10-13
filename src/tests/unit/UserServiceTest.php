<?php

namespace Tests\Unit;

use App\Classes\DAO\UserMySQLDAO;
use App\Classes\Models\User;
use App\Classes\PasswordService;
use App\Classes\SessionManager;
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

    /**
     * @var SessionManager|MockObject
     */
    private $sessionManagerStub;

    /**
     * @var PasswordService|MockObject
     */
    private $passwordServiceStub;

    /**
     * @var string The clear text password that is stored as a hash in $userModel
     */
    private $plainTextPassword;

    protected function setUp()
    {
        parent::setUp();
        $this->userDAOStub = $this->getMockBuilder(UserMySQLDAO::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sessionManagerStub = $this->getMockBuilder(SessionManager::class)
            ->getMock();
        $this->passwordServiceStub = $this->getMockBuilder(PasswordService::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['verify'])
            ->getMock();
        $this->userService = new UserService($this->userDAOStub, $this->sessionManagerStub, $this->passwordServiceStub);
        // the password for usermodel is 'Password1!' hashed in bcrypt
        $this->plainTextPassword = 'Password1!';
        $this->userModel = new User("username", "$2y$10$5vl3FfT/p/0ke1fPvUURA.TdiDH9SxAIsUxXG2yf1.r0CvTNivQAu", "Address");
    }

    public function testLogin()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with($this->userModel->getUsername())
            ->willReturn($this->userModel);
        $this->sessionManagerStub->expects($this->once())
            ->method('setUser')
            ->with($this->userModel);
        $this->sessionManagerStub->expects($this->once())
            ->method('regenerate');

        $response = $this->userService->login($this->userModel->getUsername(), "Password1!");
        $this->assertTrue($response);
    }

    public function testLoginWithNonExistentUser()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with('username')
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Incorrect authentication.');
        $this->userService->login('username', 'password');
    }

    public function testLoginWithIncorrectPassword() {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with($this->userModel->getUsername())
            ->willReturn($this->userModel);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Incorrect authentication.');
        $this->userService->login($this->userModel->getUsername(), 'password');
    }
  
    public function testCreate()
    {
        $username = $this->userModel->getUsername();
        $password = $this->plainTextPassword;
        $address = $this->userModel->getAddress();

        $this->passwordServiceStub->expects($this->once())
            ->method('isValid')
            ->with($password)
            ->willReturn(true);
        $this->passwordServiceStub->expects($this->once())
            ->method('hash')
            ->with($password)
            ->willReturn($this->userModel->getPassword());


        $this->userDAOStub->expects($this->once())
            ->method('create')
            ->with($username, $this->userModel->getPassword(), $address)
            ->willReturn($username);

        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with($username)
            ->willReturn($this->userModel);

        $response = $this->userService->create($username, $password, $address);
        // Assert that the value is returned is the value retrieved from findByUsernameAndPassword
        $this->assertEquals($this->userModel, $response);
    }

    public function testFind()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with($this->userModel->getUsername())
            ->willReturn($this->userModel);

        $this->assertEquals($this->userModel, $this->userService->find($this->userModel->getUsername()));
    }

    public function testFindUserNotFound()
    {
        $this->userDAOStub->expects($this->once())
            ->method('findOneByUsername')
            ->with($this->userModel->getUsername())
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Could not find user with username `{$this->userModel->getUsername()}`");
        $this->userService->find($this->userModel->getUsername());
    }
}
