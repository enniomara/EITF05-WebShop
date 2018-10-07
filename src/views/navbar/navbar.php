<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Webshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>

        <ul class="nav navbar-nav my-2 my-lg-0">
            <?php
                if (isset($loggedInUser)) {
                    include("navbarRightItems_loggedIn.php");
                } else {
                    include("navBarRIghtItems_notLoggedIn.php");
                }
            ?>
        </ul>
    </div>
</nav>
