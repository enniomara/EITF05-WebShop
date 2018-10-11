<?php
require('../App/global.php');

use App\Classes\View;
use App\Classes\Cart;
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\ItemService;

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemService = new ItemService($itemDAO);

$cart = new Cart();
// If cart is saved in session, use that cart instead
if ($sessionManager->getCart() !== null) {
    $cart = $sessionManager->getCart();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? null;

    // Handle adding items to cart
    if ($action === 'add') {
        $itemIds = array_keys($_POST);

        // If there are items that will be added to cart from $_POST, add them
        if (!empty($itemIds)) {
            $items = $itemService->findAllByIds(...$itemIds);

            $id = 0;
            foreach ($_POST as $itemId => $amount) {
                if ($amount !== 0) {
                    $cart->addItem($items[$id], intval($amount));
                }
                $id = $id + 1;
            }
        }

        // -------- Save cart in session------------
        if (!empty($cart->getItems())) {
            $sessionManager->setCart($cart);
        }

        // Redirect to the home page where all items are
        header('Location: home.php');
    }
}

//------------Cart rendering Rendering ----------------------
$cartItems = $cart->getItems();

$view = new View('cart');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('cartItems', $cartItems);
$view->setAttribute('cart', $cart);
$view->setAttribute('flashMessages', $flashMessageService->getMessages());

echo $view->render();
