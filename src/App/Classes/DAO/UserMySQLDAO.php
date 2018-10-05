<?php

namespace App\Classes\DAO;

use App\Interfaces\DAO\UserDAO;

class UserMySQLDAO implements UserDAO {
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
    public function findByUsernameAndPassword(string $username, string $password): array
    {
        $stmt = $this->databaseConnection->prepare('select username from users where username = ? AND password = ?');
        $stmt->execute([
            $username,
            $password
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @inheritdoc
     */
    public function create(string $username, string $password, string $address): string {
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
