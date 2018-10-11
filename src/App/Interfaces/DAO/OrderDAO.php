<?php

namespace App\Interfaces\DAO;

use App\Classes\Models\Order;

interface OrderDAO
{
    /**
     * Save an order to the database.
     *
     * @param Order $order
     */
    public function save(Order $order): void;

    /**
     * Finds order from the database by order id.
     * 
     * @param int $orderId
     */
    public function findOrder(int $orderId): array;
}
