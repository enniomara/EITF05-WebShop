<?php

namespace App\Classes;

use App\Classes\Models\Item;

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
     * @var Item[]
     */
    private $cartItems = [];

    /**
     * @param Item $item
     * @param int $amount Amount of $item instances to store
     */
    public function addItem(Item $item, int $amount = 1): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be more than 0');
        }

        // If this item has not been saved before, save it now with $amount
        if (false === array_key_exists($item->getId(), $this->cartItems)) {
            $this->cartItems[$item->getId()] = [
                'amount' => $amount,
                'item' => $item,
            ];
            return;
        }

        // Increase stored amount with $amount
        $this->cartItems[$item->getId()]['amount'] += $amount;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->cartItems;
    }

    /**
     * Calculate total price of all items on cart.
     */
    public function calculateTotalPrice(): float
    {
        $total = 0.0;

        foreach ($this->cartItems as $itemArray) {
            $itemAmount = $itemArray['amount'];
            $total += $itemArray['item']->getPrice() * $itemAmount;
        }

        return (float)$total;
    }
}
