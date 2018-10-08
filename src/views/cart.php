<html>
    <?php include("head.php"); ?>
    <body>
        <?php include("navbar/navbar.php"); ?>
        <header class="jumbotron my-4">
            <h1 class="display-1">
                <center> Your Cart</center>
            </h1>
        </header>

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
            foreach ($cartItems as $item) {
                include('cart/itemRow.php');
            }
            ?>
            <tr>
                <th></th>
                <td></td>
                <th>Totalsumma:</th>
                <th><?php echo intval($cart->calculateTotalPrice()); ?> kr</th>
            </tr>
            <tr>
                <th></th>
                <td></td>
                <th></th>
                <th><a href="/receipt.php"><input class="btn btn-primary" type="submit" value="Buy Items"></a></th>
            </tr>
        </table>

        <?php include("footer.php"); ?>

        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
                integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
                integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
                crossorigin="anonymous"></script>
    </body>
</html>
