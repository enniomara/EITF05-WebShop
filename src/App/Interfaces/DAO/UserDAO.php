<?php

namespace App\Interfaces\DAO;

use App\Classes\Models\User;

interface UserDAO
{
    /**
     * @param string $username
     * @return User|null
     */
    public function findOneByUsername(string $username): ?User;

    /**
     * Save a row in the users table.
     *
     * @param string $username
     * @param string $password
     * @param string $address
     * @return string The id of the inserted row.
     */
    public function create(string $username, string $password, string $address): string;
}
