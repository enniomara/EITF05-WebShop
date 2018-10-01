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

    public function testAddItem(): void
    {
        $item = new Item(1, "test", 20);
        $this->cart->addItem($item);

        $this->assertEquals($this->cart->getItems(), [$item]);
    }

    public function testSetItems(): void
    {
        $items = [
            new Item(1, "test", 20),
            new Item(2, "test", 20)
        ];

        // Add one non-relevant item to make sure it is overwritten
        $this->cart->addItem($items[0]);

        $this->cart->setItems($items);
        $this->assertEquals($items, $this->cart->getItems());
    }

    public function testSetItemsThatAreNotItems(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cart->setItems([
            new Item(1, "test", 20),
            'notAnItems'
        ]);
    }

    public function testCalculateTotalPriceEmptyCart(): void
    {
        $this->assertEquals(0, $this->cart->calculateTotalPrice());
    }

    public function testCalculateTotalPrice(): void
    {
        $this->cart->setItems([
            new Item(1, "test", 7),
            new Item(2, "test", 8)
        ]);
        $this->assertEquals(15, $this->cart->calculateTotalPrice());
    }
}
