<?php

namespace App\Interfaces;

interface PasswordServiceInterface
{
    public static function hash(string $password) : string;
    public function isValid(string $password) : bool;
}
