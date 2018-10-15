<?php

namespace App\Interfaces\DAO;

use App\Classes\Models\Order;

interface OrderDAO
{
    /**
     * Save an order to the database.
     *
     * @param Order $order
     * @return Order The input order but with correct order ID.
     */
    public function save(Order $order): Order;

    /**
     * Finds order from the database by order id.
     *
     * @param int $orderId
     *
     * @return array
     */
    public function findOrderItems(int $orderId): array;

    /**
     * Checks if user has rights to view a order
     *
     * @param int $orderId
     * @param string $username
     *
     * @return bool
     */
    public function checkRight(string $orderId, string $username): bool;
}
