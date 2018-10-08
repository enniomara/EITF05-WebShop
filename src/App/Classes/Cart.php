<?php

namespace App\Classes;

use App\Classes\Models\Item;
use App\Classes\Models\ItemCollection;
use App\Interfaces\Models\ItemCollectionInterface;

class Cart
{
    /**
     * Variable with all items stored in a card.
     * The format of the array is
     * ```
     * [
     *  $itemId => [
     *    'item' => $itemInstance,
     *    'amount' => $amountAsInt
     *  ]
     * ]
     * ```
     * @var ItemCollectionInterface
     */
    private $cartItems;

    public function __construct()
    {
        $this->cartItems = new ItemCollection();
    }

    /**
     * @param Item $item
     * @param int $amount Amount of $item instances to store
     */
    public function addItem(Item $item, int $amount = 1): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }

        $this->cartItems->add($item, $amount);
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->cartItems->getItems();
    }

    /**
     * Returns the number of a given item in the cart.
     * @param Item $item
     * @return int
     */
    public function getAmount(Item $item): int
    {
        return $this->cartItems->getAmount($item);
    }


    /**
     * Calculate total price of all items on cart.
     */
    public function calculateTotalPrice(): float
    {
        $total = 0.0;

        foreach ($this->cartItems->getItems() as $item) {
            $itemAmount = $this->cartItems->getAmount($item);
            $total += $item->getPrice() * $itemAmount;
        }

        return (float)$total;
    }
}
