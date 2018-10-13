<?php

namespace App\Interfaces\DAO;

use App\Classes\Models\Order;

interface OrderDAO
{
    /**
     * Save an order to the database.
     *
     * @param Order $order
     * @return int Returns the saved order id
     */
    public function save(Order $order): int;

    /**
     * Finds order from the database by order id.
     * 
     * @param int $orderId
     */
    public function findOrderItems(int $orderId): array;
}
