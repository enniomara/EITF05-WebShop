<?php

namespace App\Classes\Models;

class ItemCollection
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
    private $items = [];

    /**
     * @param Item $item
     * @param int $amount Amount of $item instances to store
     */
    public function add(Item $item, int $amount = 1): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0');
        }

        // If this item has not been saved before, save it now with $amount
        if (false === $this->contains($item)) {
            $this->items[$item->getId()] = [
                'amount' => $amount,
                'item' => $item,
            ];
            return;
        }

        // Increase stored amount with $amount
        $this->items[$item->getId()]['amount'] += $amount;
    }

    /**
     * Removes an item from the collection.
     * @param Item $item
     */
    public function remove(Item $item): void
    {
        if (array_key_exists($item->getId(), $this->items)) {
            unset($this->items[$item->getId()]);
        }
    }

    public function contains(Item $item): bool
    {
        return array_key_exists($item->getId(), $this->items);
    }

    /**
     * Get the amount of items stored in this collection.
     * @param Item $item
     * @return int
     */
    public function getAmount(Item $item): int
    {
        // If item is not in collection, return 0
        if (!$this->contains($item)) {
            return 0;
        }

        return $this->items[$item->getId()]['amount'];
    }

    public function getItems(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item['item'];
        }
        return $items;
    }


}
