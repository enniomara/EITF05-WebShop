<?php
use App\Classes\DAO\ItemMySQLDAO;
use App\Classes\Models\Item;
use App\Classes\ItemService;



$itemDAO = new ItemMySQLDAO($databaseConnection);
$itemserv = new ItemService($itemDAO);


$ordernr=1;
$username = "test";
$qu = "SELECT * FROM orderItems WHERE orderId=$ordernr";
$items =$databaseConnection->query($qu);
date_default_timezone_set('UTC');

?>


<!doctype html>
<html>
<head>



    <meta charset="utf-8">
    <title>Receipt</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


</head>

<body>
  <center>
    <h3>Receipt</h3>

          <table>
            <tr>
              <td>
                Receipt nr: <?php echo $ordernr ?>
                <br>
                Date: <?php echo date('l jS \of F Y h:i:s A'); ?>
                <br>
                </td>
                </tr>
         </table>

         <div class="row">
           <div class="col-sm-6">
            <b>Seller</b><br>
             Butik AB<br>
             Gatan gatan 1<br>
             222 22 Lund<br>
           </div>

           <div class="col-sm-6">
            <b>Costumer</b><br>
            <?php echo $username; ?><br>
            Address<br>
          </div>
         </div>
         <br>



         <div class="row">
           <div class="col-sm-3"></div>
   <div class="col-sm-6">
         <table class="table">
           <thead>
             <tr>
               <th>Produkt</th>
               <th>Antal</th>
               <th>kr/st</th>
               <th>Radnetto</th>
             </tr>
           </thead>
           <tbody>

         <?php
         $Totalsum = 0;
         foreach ($items as $key) {
           $Totalsum = $Totalsum + current($itemserv->findAllByIds($key['itemId']))->getPrice()*$key['amount'];
           echo'
               <tr>
                 <th>'.current($itemserv->findAllByIds($key['itemId']))->getName().'</th>
                 <td>'.$key['amount'].' st</td>
                 <td>'.current($itemserv->findAllByIds($key['itemId']))->getPrice().' kr</td>
                 <td>'.current($itemserv->findAllByIds($key['itemId']))->getPrice()*$key['amount'].' kr </td>
               </tr>';
         }

         echo'
             <tr>
               <th></th>
               <td></td>
               <td>Total Sum:</td>
               <td>'.$Totalsum.' kr </td>
             </tr>';


         ?>
         </table>
       </div>
     </div>
         Payed by credit card **** **** **** xxxx
         </center>

    </div>

</body>
</html>
