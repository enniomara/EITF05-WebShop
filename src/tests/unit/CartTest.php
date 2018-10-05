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
}
