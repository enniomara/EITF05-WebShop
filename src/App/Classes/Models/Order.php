<?php

namespace App\Interfaces\Models;

use App\Classes\Models\Item;

class Order
{
    /**
     * @var $id
     */
    private $id;

    private $ownerId;

    private $time;

    /**
     * @var Item[]
     */
    private $items;

    /**
     * @param int $id
     * @param $time
     */
    public function __construct(int $id, $time)
    {
        $this->id = $id;
        $this->time = $time;
    }

    /**
     * @param Item[] $items
     * @return Order
     */
    public function setItems(array $items) {
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(){
        return $this->items;
    }

    /**
     * @return int
     */
    public function getId() : int
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
