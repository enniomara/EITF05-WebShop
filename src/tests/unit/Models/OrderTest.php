<?php

namespace Tests\Unit\Models;

use App\Classes\Models\Item;
use App\Classes\Models\ItemCollection;
use App\Classes\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var ItemCollection
     */
    private $itemCollection;

    protected function setUp()
    {
        parent::setUp();
        $this->order = new Order();
        $this->itemCollection = new ItemCollection();
    }

    public function testSetItemCollection()
    {
        $this->itemCollection->add(new Item(1, "test", 24));
        $this->order->setItemCollection($this->itemCollection);

        $this->assertEquals($this->itemCollection, $this->order->getItemCollection());
    }

    public function testSetItemsEmptyArray()
    {
        $this->itemCollection->add(new Item(1, "test", 24));
        $this->order->setItemCollection($this->itemCollection);

        // Test setting it to an empty collection
        $newItemCollection = new ItemCollection();
        $this->order->setItemCollection($newItemCollection);
        $this->assertEquals($newItemCollection, $this->order->getItemCollection());
    }

    public function testGetId()
    {
        $order = new Order(1, time(), 2);
        $this->assertEquals(1, $order->getId());
    }

    public function testGetTime()
    {
        $time = time();
        $order = new Order(1, $time, 2);
        $this->assertEquals($time, $order->getTime());
    }
}
