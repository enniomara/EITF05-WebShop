<?php

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
$the_cart = $Session->getCart();

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
echo'
<table class="table">
  <thead>
    <tr>
      <th>Produkt</th>
      <th>Antal</th>
      <th>kr/st</th>
      <th>Radnetto</th>
    </tr>
  </thead>
  <tbody>';

foreach ($the_cart_items as $item) {
  echo'
      <tr>
        <th>'.$item->getName().'</th>
        <td>'.$the_cart->getAmount($item).'st</td>
        <td>'.$item->getPrice().' kr</td>
        <td>'.$item->getPrice()*$the_cart->getAmount($item).' kr </td>
      </tr>';
}

/* Unshure if buttom below works as intended */
echo'
      <tr>
        <th></th>
        <td></td>
        <th>Totalsumma:</th>
        <th>'.$the_cart->calculateTotalPrice().' kr </th>
      </tr>
      <tr>
        <th></th>
        <td></td>
        <th></th>
        <th><a href="/receipt.php"><input class="btn btn-primary" type="submit" value="Buy Items"></a></th>
      </tr>
</table>';




?>
