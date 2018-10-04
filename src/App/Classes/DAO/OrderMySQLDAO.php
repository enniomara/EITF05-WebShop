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
    public function save(Order $order): void
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
        $test = 'test';
        $statement->bindParam(':username', $test, \PDO::PARAM_STR);
        $statement->bindValue(':time', $order->getTime(), \PDO::PARAM_STR);
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

        // $valuesString is the string that contains all (?,?,?) that will be added to the prepared statement
        $valuesString = '';
        $values = [];
        foreach ($items as $index => $item) {
            $valuesString .= "( :orderId_$index, :itemId_$index, :amount_$index ) ";
            $values[$index] = [
                'orderId' => $orderId,
                'itemId' => $item->getId(),
                'amount' => $itemCollection->getAmount($item)
            ];
        }

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
