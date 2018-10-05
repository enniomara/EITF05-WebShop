<?php

namespace App\Classes;

use App\Classes\Models\Order;
use App\Interfaces\DAO\OrderDAO;

class OrderService
{
    /**
     * @var OrderDAO
     */
    private $orderDAO;

    public function __construct(OrderDAO $orderDAO)
    {
        $this->orderDAO = $orderDAO;
    }

    /**
     * Places a given order.
     * @param Order $order Save a given order.
     */
    public function place(Order $order) {
        $this->orderDAO->save($order);
    }
}
