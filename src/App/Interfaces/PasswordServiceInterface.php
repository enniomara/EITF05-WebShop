<?php

namespace App\Interfaces;

interface PasswordServiceInterface extends ServiceInterface {
    public function hash(string $password) : string;
    public function isValid(string $password) : bool;
}
