<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\Cart;
use App\Classes\Models\Item;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    private $cart;

    protected function setUp()
    {
        parent::setUp();
        $this->cart = new Cart();
    }

    public function testAddNewItemWithNoAmount(): void
    {
        $item = new Item(1, "test", 20);
        $this->cart->addItem($item);

        $this->assertEquals([
            $item->getId() => [
                'item' => $item,
                'amount' => 1
            ]
        ], $this->cart->getItems());
    }

    public function testAddNewItemWithAmount(): void
    {
        $item = new Item(1, "test", 20);
        $this->cart->addItem($item, 5);

        $this->assertEquals([
            $item->getId() => [
                'item' => $item,
                'amount' => 5
            ]
        ], $this->cart->getItems());
    }

    public function testAddItemWithNegativeAmount(): void
    {
        $item = new Item(1, "test", 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->cart->addItem($item, -4);
    }

    /**
     * If an item exists, it's amount must be increased
     */
    public function testAddExistingItem(): void
    {
        $item = new Item(1, "test", 20);
        $this->cart->addItem($item, 5);

        // Here we try to add the same item. The amount should be updated
        $this->cart->addItem($item, 4);
        $this->assertEquals([
            $item->getId() => [
                'item' => $item,
                'amount' => 9
            ]
        ], $this->cart->getItems());
    }

    public function testCalculateTotalPriceEmptyCart(): void
    {
        $this->assertEquals(0, $this->cart->calculateTotalPrice());
    }

    public function testCalculateTotalPrice(): void
    {
        $item1 = new Item(1, "test", 7);
        $item2 = new Item(2, "test", 8);

        $this->cart->addItem($item1, 2);
        $this->cart->addItem($item2, 5);
        $this->assertEquals($item1->getPrice() * 2 + $item2->getPrice() * 5, $this->cart->calculateTotalPrice());
    }

    public function testGetItems()
    {
        $item1 = new Item(1, "test", 7);
        $item2 = new Item(2, "test", 8);

        $this->cart->addItem($item1, 2);
        $this->cart->addItem($item2, 5);

        $this->assertEquals([
            $item1->getId() => [
                'item' => $item1,
                'amount' => 2
            ],
            $item2->getId() => [
                'item' => $item2,
                'amount' => 5
            ]
        ], $this->cart->getItems());
    }
}
