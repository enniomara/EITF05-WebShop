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
        $order = new Order(1, 2);
        $this->assertEquals(1, $order->getId());
    }

    public function testGetTime()
    {
        $order = new Order(1, 2);
        $this->assertNull($order->getTime());
    }

    /**
     * Test setting order time to now
     */
    public function testSetTime() {
        $time = new \DateTime();
        $this->order->setTime($time);
        $this->assertEquals($time, $this->order->getTime());
    }

    public function testGetOwnerId() {
        $order = new Order(1, "customOwnerId");
        $this->assertEquals("customOwnerId", $order->getOwnerId());
    }
}
