
<?php
$db = new PDO('mysql:host=database;dbname=webshop', 'devuser', 'devpass');
$sql= "SELECT id,name,price FROM items";
$sql_items = $db->query($sql);

// -------- Rendering Header ------------
echo '<header class="jumbotron my-4">
  <h1 class="display-3"><center>A Warm Welcome!</center></h1>
  <p class="lead">Vi säljer bla..bla...bla</p>
</header>';

// -------- Rendering Container for products ------------
echo '<div class="container">
  <div class="row text-center">';


// -------- Rendering products ------------
foreach ($sql_items as $row) {
  echo'
      <div class="col-lg-4 col-md-5 mb-4">

        <div class="card">
          <img class="card-img-top" src="http://placehold.it/500x325" alt="">

          <div class="card-body">
            <h3 class="card-title">',$row["name"],'</h3>
            <h4>',$row["price"],'kr</h4>
           </div>

          <div class="card-footer">
            <input type="number" min="0" class="form-control" id="',$row["id"],'" placeholder="Antal">
            <br>
            <a class="btn btn-primary">Lägg till i varukorg</a>
          </div>

        </div>

      </div>
    ';
}
// -------- Ending Container for products ------------
echo '
</div>
</div>';





?>
