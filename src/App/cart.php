<?php
$db = new PDO('mysql:host=database;dbname=webshop', 'devuser', 'devpass');
$sql= "SELECT * FROM orderItems INNER JOIN items ON orderItems.itemId=items.id WHERE orderItems.orderId='1'";
$sql_items = $db->query($sql);

// -------- Rendering Header ------------
echo '<header class="jumbotron my-4">
<h1 class="display-1"><center> Your Cart </center></h1>
</header>';

// -------- Ordertable head------------
echo'
<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>Produkt</th>
      <th>Antal</th>
      <th>kr/st</th>
      <th>Radnetto</th>
    </tr>
  </thead>
  <tbody>';

// -------- Ordertable rendering------------
$total_sum=0; // Order totalsum varible

//Order row rendering
foreach ($sql_items as $row) {
$row_sum= $row[amount] * $row[price]; //Row nettsum
echo"
    <tr>
      <th>$row[itemId]</th>
      <td>$row[name]</td>
      <td>$row[amount]</td>
      <td>$row[price] kr</td>
      <td>$row_sum kr</td>
    </tr>";
$total_sum = $total_sum + $row_sum; // adding each row nettsum to the order totalsum
}

// Rendering the order totalsum
echo"
  <tr>
    <th></th>
    <td></td>
    <td></td>
    <th>Summa:</th>
    <td>$total_sum kr</td>
  </tr>
  </tbody>
</table>";

?>
