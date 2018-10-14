<?php

namespace App\Interfaces;

interface PasswordServiceInterface
{
    public function hash(string $password): string;

    /**
     * Verify that a password and its hash matches.
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verify(string $password, string $hash): bool;

    public function isValid(string $password): bool;
}
