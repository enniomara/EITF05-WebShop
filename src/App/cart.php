<?php

use App\Classes\Cart;
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\Models\Item;
use App\Classes\ItemService;

$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemserv = new ItemService($itemDAO);
$the_cart = new cart();

// -------- Adding items to cart------------
$id=0;
foreach ($_POST as $key => $value) {
  if ($id!=0) {
      for ($i=0; $i < $value; $i++) {
        $the_cart->addItem(current($itemserv->findAllByIds($key)));
      }
  }
  $id=$id+1;
}

//// TODO: save cart in session


//------------Cart rendering Rendering ----------------------
$array;
foreach ($the_cart->getItems() as $key) {
  $array[]=$key->getId();
}

$printable_cart_array= array_count_values($array);

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

foreach ($printable_cart_array as $key=> $value) {
  echo'
      <tr>
        <th>'.current($itemserv->findAllByIds($key))->getName().'</th>
        <td>'.$value.' st</td>
        <td>'.current($itemserv->findAllByIds($key))->getPrice().' kr</td>
        <td>'.current($itemserv->findAllByIds($key))->getPrice()*$value.' kr </td>
      </tr>';
}
echo'
    <tr>
      <th></th>
      <td></td>
      <th>Totalsumma:</th>
      <th>'.$the_cart->calculateTotalPrice().' kr </th>
    </tr>';


    echo'
        <tr>
          <th></th>
          <td></td>
          <th></th>
          <th><input class="btn btn-primary" type="submit" value="Buy Items"></th>
        </tr>';



echo "</table>";






?>
