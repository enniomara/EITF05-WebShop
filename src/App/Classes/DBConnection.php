<?php

namespace App\Classes;

class DBConnection extends \PDO {
    public function __construct()
    {
        // TODO - move db info to .env file
        parent::__construct('mysql:host=database;dbname=webshop', 'devuser', 'devpass');
        // Set pdo to throw exceptions(by default it handles it silently)
        parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
