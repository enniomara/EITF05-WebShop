<?php

require_once __DIR__ . '/../App/autoload.php';

use App\Classes\DBConnection;

try {
    $dbh = new DBConnection();
    $items = [];
    foreach ($dbh->query('SELECT * from users') as $row) {
        $items[] = $row;
    }
    echo '<pre>';
    print_r($items);
    echo '</pre>';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
