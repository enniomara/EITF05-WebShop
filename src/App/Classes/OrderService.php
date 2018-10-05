<?php

namespace App\Classes;

use App\Interfaces\DAO\OrderDAO;
use App\Interfaces\Models\Order;

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
     * @param Order $order Save a given order.
     */
    public function save(Order $order) {
        $this->orderDAO->save($order);
    }
}
