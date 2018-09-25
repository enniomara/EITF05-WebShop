<?php

namespace App\Classes;

use App\Classes\Models\Item;

class Cart
{
    /**
     * @var Item[]
     */
    private $cartItems = [];

    public function __construct()
    {
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item): void
    {
        $cartItems[] = $item;
    }

    /**
     * @param Item[] $items
     */
    public function setItems(array $items): void
    {
        // Only set the items
        $this->cartItems = array_filter($items, function ($item) {
            if (!($item instanceof Item)) {
                throw new \InvalidArgumentException('Sent in array contains elements that are not Items.');
            }
            return true;
        });
    }
}
