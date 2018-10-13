<li class="nav-item active">
    <a class="nav-link" href="#"><?php
        echo $this->escape($loggedInUser->getUsername()) ?> <span class="sr-only">(current)</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/logout.php">Log Out</a>
</li>
