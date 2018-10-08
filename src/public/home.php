<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);
$items = $itemService->findAllItems();

$view = new View('home');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('items', $items);

echo $view->render();
