<?php

namespace App\Classes;

use App\Classes\Models\Item;

class Cart
{
    /**
     * @var Item[]
     */
    private $cartItems = [];

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $this->cartItems[] = $item;
    }

    /**
     * @param Item[] $items
     */
    public function setItems(array $items): void
    {
        // Verify that all sent values in array are Items
        $this->cartItems = array_filter($items, function ($item) {
            if (!($item instanceof Item)) {
                throw new \InvalidArgumentException('Sent in array contains elements that are not Items.');
            }
            return true;
        });
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

        foreach ($this->cartItems as $item) {
            $total += $item->getPrice();
        }

        return (float)$total;
    }
}
