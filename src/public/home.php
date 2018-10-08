<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemserv = new ItemService($itemDAO);
$sql_items = $itemserv->findAllItems();

$view = new View('home');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('sql_items', $sql_items);

echo $view->render();
