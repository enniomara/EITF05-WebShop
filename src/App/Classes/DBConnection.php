<?php

namespace App\Classes;

class DBConnection extends \PDO {
    public function __construct()
    {
        // TODO - move db info to .env file
<<<<<<< HEAD
        parent::__construct('mysql:host=localhost;dbname=webshop', 'root', '');
=======
        parent::__construct('mysql:host=database;dbname=webshop', 'devuser', 'devpass');
        // Set pdo to throw exceptions(by default it handles it silently)
        parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
>>>>>>> d297a9161704736238b5367d6984ca1d3d0f1da1
    }
}
