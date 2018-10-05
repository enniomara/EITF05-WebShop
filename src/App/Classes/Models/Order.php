<?php

namespace App\Classes\Models;

use App\Interfaces\Models\ItemCollectionInterface;
use DateTime;

class Order
{
    /**
     * @var $id
     */
    private $id;

    private $ownerId;

    /**
     * @var DateTime Time of order
     */
    private $time = null;

    /**
     * @var ItemCollectionInterface
     */
    private $itemCollection;

    /**
     * @param int $id
     * @param int $ownerId
     */
    public function __construct(int $id = 0, $ownerId = 0)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;

        $this->itemCollection = new ItemCollection();
    }

    /**
     * @param ItemCollectionInterface $itemCollection
     * @return Order
     */
    public function setItemCollection(ItemCollectionInterface $itemCollection): Order
    {
        $this->itemCollection = $itemCollection;
        return $this;
    }

    /**
     * @return ItemCollectionInterface
     */
    public function getItemCollection(): ItemCollectionInterface
    {
        return $this->itemCollection;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getTime(): DateTime
    {
        return $this->time;
    }

    /**
     * @param DateTime|null $time
     */
    public function setTime(DateTime $time = null)
    {
        $this->time = $time;
        // If time is not set set it to now
        if (!isset($time)) {
            $this->time = new DateTime();
        } else {
            $this->time = $time;
        }
    }
}
