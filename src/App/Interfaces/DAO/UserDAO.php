<?php

namespace App\Interfaces\DAO;

interface UserDAO {
    /**
     * @param string $username
     * @param string $password
     * @return array Database row results.
     */
    public function findByUsernameAndPassword(string $username, string $password) : array;
}
