<html>
    <body>
        <form action="login.php" name="login" method="POST">
            <label for="username">Username:</label> <input type="text" name="username">
            <br />
            <label for="password">Password:</label> <input type="password" name="password">
            <br />
            <button type="submit">Submit</button>
        </form>
    </body>
</html>

<?php

require_once __DIR__ . '/../App/global.php';

use App\Classes\UserService;

// Handle case when login is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    echo "login set";
    $userService = new UserService($databaseConnection);
    $loggedIn = $userService->login($_POST['username'], $_POST['password']);

    if ($loggedIn) {
        echo "logged in \n";
    }
}
?>

