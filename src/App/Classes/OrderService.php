<?php

namespace App\Classes;

use App\Classes\Models\Order;
use App\Interfaces\DAO\OrderDAO;
use App\Interfaces\PaymentServiceInterface;

class OrderService
{
    /**
     * @var OrderDAO
     */
    private $orderDAO;

    /**
     * @var PaymentServiceInterface
     */
    private $paymentService;

    public function __construct(OrderDAO $orderDAO)
    {
        $this->orderDAO = $orderDAO;
    }

    /**
     * Places a given order (makes payment and saves order).
     * @param Order $order
     */
    public function place(Order $order, PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
        $totalAmount = 0;
        foreach ($order->getItemCollection()->getItems() as $item) {
            $totalAmount += $item->getPrice() * $order->getItemCollection()->getAmount($item);
        }
        $this->paymentService->setAmount($totalAmount);
        $this->paymentService->pay();

        // Attempt to perform an order
        $this->orderDAO->save($order);
    }

    /**
     * Find order items by order id.
     * 
     * @param int $orderId
     */
    public function findOrder(int $orderId): array{
        return $this->orderDAO->findOrder($orderId);
    }
}
