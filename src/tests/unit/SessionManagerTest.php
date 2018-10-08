<?php

namespace Tests\Unit;

use App\Classes\Models\User;
use App\Classes\SessionManager;
use PHPUnit\Framework\TestCase;
use App\Classes\Cart;

class SessionManagerTest extends TestCase
{
    /**
     * @var SessionManager
     */
    private $session;

    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var User
     */
    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->session = new SessionManager();
        $this->cart = new Cart();
        $this->user = new User("username", null, null);
    }

    public function testCheckIfUserSet(): void
    {
        $this->assertFalse($this->session->isUserSet());
        $this->session->setUser($this->user);
        $this->assertTrue($this->session->isUserSet());
    }

    public function testSetUser(): void
    {
        $this->session->setUser($this->user);

        $this->assertEquals($this->user->getUsername(), $this->session->getUser()['userId']);
    }
}
