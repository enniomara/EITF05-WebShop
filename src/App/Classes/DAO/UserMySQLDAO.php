<?php

namespace App\Classes\DAO;

use App\Classes\Models\User;
use App\Interfaces\DAO\UserDAO;

class UserMySQLDAO implements UserDAO
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
     * @inheritdoc
     */
    public function findOneByUsernameAndPassword(string $username, string $password): ?User
    {
        $stmt = $this->databaseConnection->prepare('select username, address from users where username = ? AND password = ?');
        $stmt->execute([
            $username,
            $password
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }
        return new User($result[0]['username'], null, $result[0]['address']);
    }

    /**
     * @inheritdoc
     */
    public function findOneByUsername(string $username): ?User
    {
        $stmt = $this->databaseConnection->prepare('select username, password, address from users where username = ?');
        $stmt->execute([
            $username,
        ]);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }
        return new User($result[0]['username'], $result[0]['password'], $result[0]['address']);
    }

    /**
     * @inheritdoc
     */
    public function create(string $username, string $password, string $address): string
    {
        $sql = "INSERT INTO users(username, password, address) VALUES (:username, :password, :address)";
        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':address', $address);

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new \InvalidArgumentException('User already exists.');
            }

            throw $e;
        }

        return $username;
    }

}
