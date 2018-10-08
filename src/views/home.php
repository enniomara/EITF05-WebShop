<html>
<?php include("head.php"); ?>
<body>
    <?php include("navbar/navbar.php"); ?>


    <header class="jumbotron my-4">
        <h1 class="display-3">
            <center>A Warm Welcome!</center>
        </h1>
        <p class="lead">Vi säljer bla..bla...bla</p>
    </header>


    <div class="container">

            <div class="row text-center">

                <?php
                foreach ($items as $item) {
                    echo '
                        <div class="col-lg-4 col-md-5 mb-4">
                    <form action="cart.php?action=add" method="post">
                    <div class="card">
                      <img class="card-img-top" src="http://placehold.it/500x325" alt="">

                      <div class="card-body">
                        <h3 class="card-title">', $this->escape($item->getName()), '</h3>
                        <h4>', $this->escape($item->getPrice()), 'kr</h4>
                       </div>
                      <div class="card-footer">
                        <input type="number" min="0" class="form-control"  name="', intval($item->getId()), '" placeholder="Antal">
                        <br>
                        <input class="btn btn-primary" type="submit" value="Add items to cart">

                      </div>

                    </div>

                  </div>
                  </form>
                ';
                }
                ?>

            </div>

    </div>

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
