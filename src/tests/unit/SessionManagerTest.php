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

    public function testCheckIfUserSet(): void {
        $this->assertFalse($this->session->isUserSet());

        $userId = 1234567;
        $this->session->setUser($userId);

        $this->assertTrue($this->session->isUserSet());
    }

    public function testSetUser(): void{
        $userId = 1234567;
        $this->session->setUser($userId);

        $this->assertEquals($userId, $this->session->getUser()['userId']);
    }
}