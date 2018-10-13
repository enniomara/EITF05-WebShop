<?php

namespace App\Interfaces;

interface PaymentServiceInterface {
    /**
     * Set amount of transaction.
     * @param int $value
     */
    public function setAmount(int $value): void;
    public function pay();
}
