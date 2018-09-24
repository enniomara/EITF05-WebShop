<?php

require_once __DIR__ . '/../App/autoload.php';

use App\Classes\DBConnection;
use App\Classes\SessionManager;

try {
    $dbh = new DBConnection();
    $session = new SessionManager();
    $items = [];
    foreach ($dbh->query('SELECT * from users') as $row) {
        $items[] = $row;
    }
    $session::startSession('test');
    echo '<pre>';
    print_r($items);
    echo '</pre>';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
