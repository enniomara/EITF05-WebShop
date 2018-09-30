<?php

namespace App\Classes;

use App\Interfaces\DAO\UserDAO;

class UserService
{
    /**
     * @var UserDAO
     */
    private $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool If login was successful or not
     * @throws \InvalidArgumentException When authentication fails
     */
    public function login(string $username, string $password) : bool
    {
        /** Validate credentials */

        /** Hash password */
        $hashedPassword = PasswordService::hash($password);

        /** Check against database */
        $result = $this->userDAO->findByUsernameAndPassword($username, $hashedPassword);
        if (empty($result)) {
            throw new \InvalidArgumentException('Incorrect authentication');
        }

        /** Set session */

        return true;
    }

    public function create(string $username, string $password)
    {
        /** Validate username and password */
        /** Validate username does not exist */
        /** Generate hash */
        /** Save to db */
        /** Return created user */
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
