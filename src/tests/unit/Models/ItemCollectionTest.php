<?php

namespace Tests\Unit\Models;

use App\Classes\Models\Item;
use App\Classes\Models\ItemCollection;
use PHPUnit\Framework\TestCase;

class ItemCollectionTest extends TestCase
{
    /**
     * @var ItemCollection
     */
    private $itemCollection;

    protected function setUp()
    {
        parent::setUp();

        $this->itemCollection = new ItemCollection();
    }

    public function testAddNewItemWithNoAmount(): void
    {
        $item = new Item(1, "test", 20);
        $this->itemCollection->add($item);

        $this->assertEquals([
            $item,
        ], $this->itemCollection->getItems());
        $this->assertEquals(1, $this->itemCollection->getAmount($item));
    }

    public function testAddNewItemWithAmount(): void
    {
        $item = new Item(1, "test", 20);
        $this->itemCollection->add($item, 5);

        $this->assertEquals([
            $item,
        ], $this->itemCollection->getItems());
        $this->assertEquals(5, $this->itemCollection->getAmount($item));
    }

    public function testAddWithNegativeAmount(): void
    {
        $item = new Item(1, "test", 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->itemCollection->add($item, -4);
    }

    /**
     * Adding an existing item should result in the amount being increased
     */
    public function testAddExistingItem(): void {
        $item = new Item(1, "test", 20);
        $this->itemCollection->add($item, 2);

        $this->itemCollection->add($item, 10);

        $this->assertEquals(12, $this->itemCollection->getAmount($item));
    }

    public function testContains(): void
    {
        $item = new Item(1, "test", 20);
        $item2 = new Item(2, "test", 20);

        $this->itemCollection->add($item);
        $this->assertTrue($this->itemCollection->contains($item));
        $this->assertFalse($this->itemCollection->contains($item2));
    }

    public function testGetAmount(): void
    {
        $item = new Item(1, "test", 20);
        $this->assertEquals(0, $this->itemCollection->getAmount($item));

        $this->itemCollection->add($item, 2);
        $this->assertEquals(2, $this->itemCollection->getAmount($item));
    }

    public function testGetItems(): void
    {
        // Test that an empty array is returned when there are no items
        $array = $this->itemCollection->getItems();
        $this->assertInternalType('array', $array);
        $this->assertEmpty($array);

        $item = new Item(1, "test", 20);
        $item2 = new Item(2, "test", 20);
        $this->itemCollection->add($item);
        $this->itemCollection->add($item2, 5);

        $array = $this->itemCollection->getItems();

        $this->assertInternalType('array', $array);
        $this->assertEquals([
            $item,
            $item2
        ], $array);
    }

    public function testRemove(): void
    {
        $item = new Item(1, "test", 20);
        $item2 = new Item(2, "test", 20);

        $this->itemCollection->add($item);
        $this->itemCollection->add($item2);
        $this->itemCollection->remove($item);

        $this->assertEquals([$item2], $this->itemCollection->getItems());
    }

    public function testRemoveItemNotExists(): void
    {
        $item = new Item(1, "test", 20);
        $item2 = new Item(2, "test", 20);
        $this->itemCollection->add($item);

        $itemsBeforeRemove = $this->itemCollection->getItems();
        $this->itemCollection->remove($item2);

        $this->assertEquals($itemsBeforeRemove, $this->itemCollection->getItems());
    }
}
