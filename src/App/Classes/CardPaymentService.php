<?php

namespace App\Classes;

use App\Interfaces\PaymentServiceInterface;

class CardPaymentService implements PaymentServiceInterface
{
    /**
     * @var int
     */
    private $amount;

    /**
     * CardPaymentService constructor.
     * @param $cardNr Number of the card.
     * @param $cvv
     * @param $expiryDate
     */
    public function __construct($cardNr, $cvv, $expiryDate)
    {
    }

    /**
     * @inheritdoc
     */
    public function setAmount(int $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }
        $this->amount = $amount;
    }

    public function pay()
    {
        return true;
    }
}
