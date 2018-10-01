<?php

namespace App\Interfaces;

interface PasswordServiceInterface
{
    public static function hash(string $password) : string;
    public static function isValid(string $password) : bool;
}
