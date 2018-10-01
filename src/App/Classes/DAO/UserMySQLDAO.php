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
}
