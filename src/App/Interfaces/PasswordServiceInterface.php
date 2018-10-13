<?php

namespace App\Interfaces;

interface PasswordServiceInterface
{
    public static function hash(string $password) : string;
    public function isValid(string $password) : bool;
    /**
     * Verify that a password and its hash matches.
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verify(string $password, string $hash): bool;

}
