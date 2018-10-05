<?php

namespace App\Interfaces\DAO;

interface UserDAO {
    /**
     * @param string $username
     * @param string $password
     * @return array Database row results.
     */
    public function findByUsernameAndPassword(string $username, string $password) : array;

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
