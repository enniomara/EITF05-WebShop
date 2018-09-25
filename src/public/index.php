<?php

require_once __DIR__ . '/../App/global.php';

try {
    $items = [];
    foreach ($databaseConnection->query('SELECT * from users') as $row) {
        $items[] = $row;
    }
    echo '<pre>';
    print_r($items);
    echo '</pre>';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
