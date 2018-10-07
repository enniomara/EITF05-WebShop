<?php
  require('../App/global.php');
  use App\Classes\View;
  use App\Classes\Cart;
  use App\Classes\DAO\ItemMySQLDAO;
  use App\Classes\Models\Item;
  use App\Classes\ItemService;
  use App\Classes\DAO\OrderMySQLDAO;
  use App\Classes\Models\Order;
  use App\Classes\OrderService;
  use App\Classes\SessionManager;

  $itemDAO = new ItemMySQLDAO($databaseConnection);
  $itemserv = new ItemService($itemDAO);
  $Session = new SessionManager();
  $the_cart = new Cart();

  $Session->start();

  // -------- Adding Session cart if it exists------------
  if ($Session->getCart()!= null) {
  $the_cart = $Session->getCart();
  }

  // -------- Adding items to cart------------
  $array = array_keys($_POST);

  if (sizeof($array)>0) {
  $items = $itemserv->findAllByIds(...$array);

  $id=0;
  foreach ($_POST as $itemid => $amount) {
    if ($amount!=0) {
      $the_cart->addItem($items[$id],intval($amount));
   }
    $id=$id+1;
  }
  }

  // -------- Save cart in session------------
  if (sizeof($the_cart->getItems())!= 0) {
  $Session->setCart($the_cart);
  }
  //------------Cart rendering Rendering ----------------------
  $the_cart_items = $the_cart->getItems();


  $view = new View('your_cart');
  $view->setAttribute('loggedInUser', $loggedInUser);
  $view->setAttribute('the_cart_items', $the_cart_items);
  $view->setAttribute('the_cart', $the_cart);


  echo $view->render();
  ?>
