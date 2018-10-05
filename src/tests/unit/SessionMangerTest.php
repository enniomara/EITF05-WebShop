<?php

namespace Tests\Unit;

use App\Classes\SessionManager;
use PHPUnit\Framework\TestCase;
use App\Classes\Cart;
use App\Classes\Models\Item;

class SessionManagerTest extends TestCase{

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var Cart
     */
    private $cart;

    protected function setUp(){
        parent::setUp();
        $this->session = new SessionManager();
        $this->cart = new Cart();
    }

    public function testSetUser(): void{
        $userId = 1234567;
        $this->session->setUser($userId);

        $this->assertEquals($userId, $this->session->getUser()['userId']);
    }

    public function testCheckIfUserSet(): void {
        $userId = 1234567;
        $this->session->setUser($userId);

        $this->assertTrue($this->session->checkIfUserSet());
    }

    public function testSetCart(): void {
        $item = new Item(1, "test", 20);
        $this->cart->addItem($item);

        $this->session->setCart($this->cart);

        $this->assertEquals($this->session->getCart()->getItems(), [$item]);
    }

}