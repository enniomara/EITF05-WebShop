<?php

namespace App\Classes\Models;

class User {
    private $username;
    private $password;
    private $address;

    public function __construct(?string $username, ?string $password, ?string $address)
    {
        $this->username = $username;
        $this->password = $password;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}
