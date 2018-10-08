<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\Cart;
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\ItemService;

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);
$cart = new Cart();

// -------- Adding Session cart if it exists------------
if ($sessionManager->getCart() != null) {
    $cart = $sessionManager->getCart();
}

// -------- Adding items to cart------------
$array = array_keys($_POST);

if (sizeof($array) > 0) {
    $items = $itemService->findAllByIds(...$array);

    $id = 0;
    foreach ($_POST as $itemId => $amount) {
        if ($amount != 0) {
            $cart->addItem($items[$id], intval($amount));
        }
        $id = $id + 1;
    }
}

// -------- Save cart in session------------
if (sizeof($cart->getItems()) != 0) {
    $sessionManager->setCart($cart);
}
//------------Cart rendering Rendering ----------------------
$cartItems = $cart->getItems();


$view = new View('your_cart');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('cartItems', $cartItems);
$view->setAttribute('cart', $cart);


echo $view->render();
