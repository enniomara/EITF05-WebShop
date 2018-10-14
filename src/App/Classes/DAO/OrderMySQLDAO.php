<?php

namespace App\Classes\DAO;

use App\Classes\Models\Order;
use App\Interfaces\DAO\OrderDAO;
use App\Interfaces\Models\ItemCollectionInterface;
use PDOStatement;

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

    /**
     * @inheritdoc
     */
    public function save(Order $order): Order
    {
        $this->databaseConnection->beginTransaction();

        // Save order in orders
        $statement = $this->insertOrderPDOStatement($order);
        $statement->execute();
        $createdOrderId = $this->databaseConnection->lastInsertId();
        // Save items in orderItems
        $statement = $this->insertItemsPDOStatement($createdOrderId, $order->getItemCollection());
        $statement->execute();

        $this->databaseConnection->commit();

        $order->setId($createdOrderId);
        return $order;
    }

    /**
     * @inheritdoc
     */
    public function checkRight(int $orderId, $username): bool{
        $sql = "SELECT id, username FROM orders WHERE id = :orderId AND username = :username";
        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindValue(':orderId', $orderId);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();

        return empty($statement->fetchAll());
    }

    /**
     * @inheritdoc
     */
    public function findOrderItems(int $orderId): array{
        $sql = "SELECT id, name, price, amount FROM orderItems INNER JOIN items ON orderItems.itemId=items.id WHERE orderId = :orderId";
        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindValue(':orderId', $orderId);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Create PDOStatement that inserts the given order.
     *
     * @param Order $order
     * @return PDOStatement
     */
    private function insertOrderPDOStatement(Order $order): PDOStatement
    {
        $sql = 'INSERT INTO orders (username, time) VALUES (:username, :time)';
        $statement = $this->databaseConnection->prepare($sql);
        $statement->bindValue(':username', $order->getOwnerId(), \PDO::PARAM_STR);
        $statement->bindValue(':time', $order->getTime()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        return $statement;
    }

    /**
     * Create PDOStatement that inserts the given items.
     *
     * @param int $orderId
     * @param ItemCollectionInterface $itemCollection
     * @return PDOStatement
     */
    private function insertItemsPDOStatement(int $orderId, ItemCollectionInterface $itemCollection): PDOStatement
    {
        $items = $itemCollection->getItems();

        if (empty($items)) {
            throw new \InvalidArgumentException('ItemCollection has no items');
        }

        // $valuesString is the string that contains all (?,?,?) that will be added to the prepared statement
        $valuesString = '';
        $values = [];
        foreach ($items as $index => $item) {
            $valuesString .= "( :orderId_$index, :itemId_$index, :amount_$index ),";
            $values[$index] = [
                'orderId' => $orderId,
                'itemId' => $item->getId(),
                'amount' => $itemCollection->getAmount($item)
            ];
        }
        // Remove the last comma (,) from $valuesString
        $valuesString = \substr($valuesString, 0, -1);

        $sql = "INSERT INTO orderItems (orderId, itemId, amount) VALUES {$valuesString}";

        $statement = $this->databaseConnection->prepare($sql);
        foreach ($values as $index => $value) {
            print_r($value);
            $statement->bindValue(":orderId_$index", $value['orderId']);
            $statement->bindValue(":itemId_$index", $value['itemId']);
            $statement->bindValue(":amount_$index", $value['amount']);
        }

        return $statement;
    }
}
