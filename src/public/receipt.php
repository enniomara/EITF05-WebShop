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

// Finding orders
$orders = $orderService->findOrderItems($orderId);

// Adding the orders to a cart for easier handeling
$cart = new Cart();
foreach ($orders as $order){
    $cart->addItem($itemService->findAllByIds($order['itemId'])[0], $order['amount']);
}

// Getting cart items
$cartItems = $cart->getItems();

$view = new View('receipt');
$view->setAttribute('title', 'Receipt#' . $orderId);
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('cart', $cart);
$view->setAttribute('cartItems', $cartItems);
$view->setAttribute('orderId', $orderId);


echo $view->render();