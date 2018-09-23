<?php

// -------- Rendering Navbar ------------
function navbar() {
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <h3 style="color:white">Webbshop</h3>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="/index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/your_cart.php">Varukorg</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>';
}

// -------- Rendering Page head ------------
function head() {
    echo '<head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>???</title>

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>';
}
// -------- Rendering Page footer ------------
function footer() {
echo '<footer class="py-5 bg-dark">
</footer>';
}

 ?>
