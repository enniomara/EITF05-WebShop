<?php

namespace App\Interfaces\Models;

use App\Classes\Models\Item;

interface ItemCollectionInterface
{
    /**
     * @param Item $item
     * @param int $amount Amount of $item instances to store
     */
    public function add(Item $item, int $amount = 1): void;

    /**
     * Removes an item from the collection.
     * @param Item $item
     */
    public function remove(Item $item): void;

    /**
     * See if the collection contains an item.
     * @param Item $item
     * @return bool
     */
    public function contains(Item $item): bool;

    /**
     * Get the amount of items stored in this collection.
     * @param Item $item
     * @return int
     */
    public function getAmount(Item $item): int;

    /**
     * Return an array with all items (no amount).
     * @return Item[]
     */
    public function getItems(): array;
}
