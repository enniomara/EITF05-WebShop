<?php

namespace App\Classes;

class DBConnection extends \PDO {
    public function __construct()
    {
        // TODO - move db info to .env file
        parent::__construct('mysql:host=localhost;dbname=webshop', 'root', '');
    }
}
