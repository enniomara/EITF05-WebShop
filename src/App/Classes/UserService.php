<?php

namespace App\Classes;

use App\Interfaces\ServiceInterface;

class UserService implements ServiceInterface
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    public function __construct(\PDO $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
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
        $hashedPassword = (new PasswordService())->hash($password);

        /** Check against database */
        $stmt = $this->databaseConnection->prepare('select username from users where username = ? AND password = ?');
        $stmt->execute([
            $username,
            $hashedPassword
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

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
    public function hash(string $password): string
    {
        return $password;
    }

    public function isValid(string $password): bool
    {
        return true;
    }
}
