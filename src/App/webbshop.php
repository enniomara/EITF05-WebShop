
<?php
#// TODO: DB-connection needs to be updated to same as index.php
//$db = new PDO('mysql:host=database;dbname=webshop', 'devuser', 'devpass');
//Selecting the sql table
//$sql= "SELECT id,name,price FROM items";
//$sql_items = $db->query($sql);

use App\Classes\ItemService;
use App\Classes\DAO\ItemMySQLDAO;
$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemserv =new ItemService($itemDAO);
$sql_items = $itemserv->findAllItems();


// -------- Rendering Header ------------
echo '<header class="jumbotron my-4">
  <h1 class="display-3"><center>A Warm Welcome!</center></h1>
  <p class="lead">Vi säljer bla..bla...bla</p>
</header>';

// -------- Rendering Container for products ------------
echo '<div class="container">
  <form action="your_cart.php" method="post">
  <div class="row text-center">';


// -------- Rendering products ------------
foreach ($sql_items as $row) {
  echo'
      <div class="col-lg-4 col-md-5 mb-4">

        <div class="card">
          <img class="card-img-top" src="http://placehold.it/500x325" alt="">

          <div class="card-body">
            <h3 class="card-title">',$row->getName(),'</h3>
            <h4>',$row->getPrice(),'kr</h4>
           </div>
          <div class="card-footer">
            <input type="hidden" name="id" value="',$row->getId(),'">
            <input type="number" min="0" class="form-control"  name="',$row->getId(),'" placeholder="Antal">
            <br>
            <input class="btn btn-primary" type="submit" value="Add items to cart">

          </div>

        </div>

      </div>
    ';
}
// -------- Ending Container for products ------------
echo '
</div>
</form>
</div>';
?>
