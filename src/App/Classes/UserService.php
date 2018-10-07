<?php

namespace App\Classes;

use App\Classes\Models\User;
use App\Interfaces\DAO\UserDAO;

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

    public function __construct(UserDAO $userDAO, SessionManager $sessionManager)
    {
        $this->userDAO = $userDAO;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool If login was successful or not
     * @throws \InvalidArgumentException When authentication fails
     */
    public function login(string $username, string $password): bool
    {
        /** Validate credentials */

        /** Hash password */
        $hashedPassword = PasswordService::hash($password);

        /** Check against database */
        $user = $this->userDAO->findOneByUsernameAndPassword($username, $hashedPassword);
        if (null === $user) {
            throw new \InvalidArgumentException('Incorrect authentication');
        }

        /** Set session */
        $this->sessionManager->setUser($user);

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
        /** Generate hash */
        $hashedPassword = PasswordService::hash($password);
        /** Save to db */
        $result = $this->userDAO->create($username, $password, $address);
        /** Return created user */
        return $this->userDAO->findOneByUsernameAndPassword($result, $hashedPassword);
    }
}

// Mocked version of password service. Swap with real one when it is implemented
class PasswordService implements \App\Interfaces\PasswordServiceInterface
{
    public static function hash(string $password): string
    {
        return $password;
    }

    public static function isValid(string $password): bool
    {
        return true;
    }
}
