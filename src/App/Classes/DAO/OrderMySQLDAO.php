<?php

namespace App\Classes\DAO;

use App\Interfaces\DAO\OrderDAO;
use App\Interfaces\Models\Order;

class OrderMySQLDAO implements OrderDAO
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    public function __construct(\PDO $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function save(Order $order) {
        $this->databaseConnection->beginTransaction();

        $sql = 'INSERT INTO orders (id, username, time) VALUES (:id, :username, :time)';
        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindParam(':id', $order->getId(), \PDO::PARAM_INT);
        $test = 'asd';
        $statement->bindParam(':username', $test, \PDO::PARAM_STR);
        $statement->bindParam(':time', $order->getTime(), \PDO::PARAM_STR);
        $statement->execute();

        $this->databaseConnection->commit();
        // Save items in orderItems
        // Save order in orders
    }
}
