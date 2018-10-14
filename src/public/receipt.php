<?php
require('../App/global.php');

// Checking if user is not set
if(!$sessionManager->isUserSet()){
    echo "<h1>404</h1><p>Not found</p>";
    exit();
}

use App\Classes\View;
use App\Classes\OrderService;
use App\Classes\DAO\OrderMySQLDAO;
use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\Cart;


$orderDAO =  new OrderMySQLDAO($databaseConnection);
$orderService = new OrderService($orderDAO);
$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);

// Getting id from http header
$orderId = intval($_GET['orderId']);

// Finding order items
$items = $orderService->findOrderItems($orderId, $databaseConnection);

$cart = new Cart();
foreach($items->getItems() as $item){
    $cart->addItem($item, $items->getAmount($item));
}

$view = new View('receipt');
$view->setAttribute('title', 'Receipt#' . $orderId);
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('cart', $cart);
$view->setAttribute('items', $items->getItems());
$view->setAttribute('orderId', $orderId);


echo $view->render();