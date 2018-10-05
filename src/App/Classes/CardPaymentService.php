<?php

namespace App\Classes;

use App\Interfaces\PaymentServiceInterface;

class CardPaymentService implements PaymentServiceInterface
{
    /**
     * CardPaymentService constructor.
     * @param $cardNr Number of the card.
     * @param $cvv
     * @param $expiryDate
     */
    public function __construct($cardNr, $cvv, $expiryDate)
    {
    }

    public function pay()
    {
        return true;
    }
}
