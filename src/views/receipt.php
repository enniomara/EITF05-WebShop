<!DOCTYPE html>
<html>
    <?php include('head.php') ?>
    <body>
        <?php include('navbar/navbar.php') ?>
        <br><br>
        <div class="container">
        <div class="row">
        <center>
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>WEEBSHOP</strong>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Order #: <?php echo intval($orderId) ?></em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <h1>Receipt</h1>
                    </div>
                    </span>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>#</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $item){
                                include('receipt/itemRow.php');
                            } 
                            ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td class="text-right"> 
                                    <p>
                                        <strong>Tax: </strong>
                                    </p>
                                    <p>
                                        <strong>Subtotal: </strong>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <p>
                                        <strong>0</strong>
                                    </p>
                                    <p>
                                        <strong><?php echo intval($cart->calculateTotalPrice()); ?></strong>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td class="text-right"><h4><strong>Total: </strong></h4></td>
                                <td class="text-center text-danger"><h4><strong><?php echo intval($cart->calculateTotalPrice()); ?></strong></h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <center>
            </div>
        </div>
    </body>
</html>