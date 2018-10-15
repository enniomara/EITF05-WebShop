<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\OrderService;
use App\Classes\DAO\OrderMySQLDAO;
use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\Cart;

if (!isset($_GET['orderId'])) {
    $view = new View('error404');
    echo $view->render();
    exit();
}
// Getting id from http header
$orderId = intval($_GET['orderId']);

if (false === $sessionManager->isUserSet()) {
    $flashMessageService->add('You must be logged in.', \App\Interfaces\FlashMessageServiceInterface::ERROR);
    header("Location: /login.php");
    exit();
}

$orderDAO =  new OrderMySQLDAO($databaseConnection);
$orderService = new OrderService($orderDAO);

// Checking if user is not set
if (!($sessionManager->isUserSet() && $orderService->checkRight($orderId, $sessionManager->getUser()['userId']))) {
    $view = new View('error404');
    echo $view->render();
    exit();
}

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);

// Finding order items
$items = $orderService->findOrderItems($orderId, $databaseConnection);

$cart = new Cart();
foreach ($items->getItems() as $item) {
    $cart->addItem($item, $items->getAmount($item));
}

$view = new View('receipt');
$view->setAttribute('title', 'Receipt#' . $orderId);
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('cart', $cart);
$view->setAttribute('items', $items->getItems());
$view->setAttribute('orderId', $orderId);


echo $view->render();
