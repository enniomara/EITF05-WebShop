<?php

namespace App\Classes;

use App\Classes\Models\Order;
use App\Interfaces\DAO\OrderDAO;
use App\Interfaces\PaymentServiceInterface;
use App\Classes\Models\ItemCollection;
use App\Classes\Models\Item;

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
     * Places a given order (makes payment and saves order).
     * @param Order $order
     * @param PaymentServiceInterface $paymentService
     * @return Order The same input order but with correct order ID.
     */
    public function place(Order $order, PaymentServiceInterface $paymentService): Order
    {
        $totalAmount = 0;
        foreach ($order->getItemCollection()->getItems() as $item) {
            $totalAmount += $item->getPrice() * $order->getItemCollection()->getAmount($item);
        }
        $paymentService->setAmount($totalAmount);
        $paymentService->pay();

        // Attempt to perform an order
        return $this->orderDAO->save($order);
    }

    /**
     * Find order items by order id.
     *
     * @param int $orderId
     * @return ItemCollection
     */
    public function findOrderItems(int $orderId): ItemCollection{
        $orderItems = $this->orderDAO->findOrderItems($orderId);
        $itemCollection = new ItemCollection();

        foreach($orderItems as $item){
            $itemCollection->add(new Item($item['id'], $item['name'], $item['price']), $item['amount']);
        }

        return $itemCollection;
    }
}
