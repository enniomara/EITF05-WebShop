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
}
