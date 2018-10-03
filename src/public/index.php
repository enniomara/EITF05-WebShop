<?php

require_once __DIR__ . '/../App/global.php';

use App\Classes\SessionManager;

try {
    $session = new SessionManager();

    //Starting session
    try{
        $session->start();
    } catch(Exception $e){
        echo $e;
    }

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
