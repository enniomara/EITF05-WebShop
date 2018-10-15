<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;

if (false === $sessionManager->isUserSet()) {
    $flashMessageService->add('You must be logged in.', \App\Interfaces\FlashMessageServiceInterface::ERROR);
    header("Location: /login.php");
    exit();
}

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);
$items = $itemService->findAllItems();

$view = new View('index');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('items', $items);
$view->setAttribute('flashMessages', $flashMessageService->getMessages());

echo $view->render();
