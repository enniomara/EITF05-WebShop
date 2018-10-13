<?php

namespace App\Classes;

use App\Classes\Models\User;
use App\Interfaces\DAO\UserDAO;
use App\Interfaces\PasswordServiceInterface;

class UserService
{
    /**
     * @var UserDAO
     */
    private $userDAO;

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * @var PasswordServiceInterface
     */
    private $passwordService;

    public function __construct(UserDAO $userDAO, SessionManager $sessionManager, PasswordServiceInterface $passwordService)
    {
        $this->userDAO = $userDAO;
        $this->sessionManager = $sessionManager;
        $this->passwordService = $passwordService;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool If login was successful or not
     * @throws \InvalidArgumentException When authentication fails
     */
    public function login(string $username, string $password): bool
    {
        $user = $this->userDAO->findOneByUsername($username);

        if (null === $user) {
            throw new \InvalidArgumentException('Incorrect authentication.');
        }

        // Validate password matches with hash
        if (false === $this->passwordService::verify($password, $user->getPassword())) {
            throw new \InvalidArgumentException('Incorrect authentication.');
        }

        /** Set session */
        $this->sessionManager->setUser($user);
        $this->sessionManager->regenerate();

        return true;
    }

    /**
     * Finds a user from the database
     *
     * @param string $username
     * @return User
     */
    public function find(string $username): User
    {
        $user = $this->userDAO->findOneByUsername($username);
        if (null === $user) {
            throw new \InvalidArgumentException("Could not find user with username `$username`");
        }

        return $user;
    }

    /**
     * Create a user
     * @param string $username
     * @param string $password
     * @param string $address
     * @return Models\User|null
     */
    public function create(string $username, string $password, string $address): User
    {
        /** Validate credentials */
        if (false === $this->passwordService->isValid($password)) {
            throw new \InvalidArgumentException("Password is invalid.");
        }

        /** Generate hash */
        $hashedPassword = $this->passwordService->hash($password);
        /** Save to db */
        $result = $this->userDAO->create($username, $hashedPassword, $address);
        /** Return created user */
        return $this->userDAO->findOneByUsername($result);
    }
}

