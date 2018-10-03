<?php

namespace App\Classes\Models;

use App\Interfaces\Models\ItemCollectionInterface;

class Order
{
    /**
     * @var $id
     */
    private $id;

    private $ownerId;

    private $time;

    /**
     * @var ItemCollectionInterface
     */
    private $itemCollection;

    /**
     * @param int $id
     * @param $time
     * @param $ownerId
     */
    public function __construct(int $id = 0, $time = 0, $ownerId = 0)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->time = $time;
    }

    /**
     * @param ItemCollectionInterface $itemCollection
     * @return Order
     */
    public function setItemCollection(ItemCollectionInterface $itemCollection)
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
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }
}
