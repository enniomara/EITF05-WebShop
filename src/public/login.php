<html>
    <body>
        <h1>Login:</h1>
        <form action="login.php?action=login" name="login" method="POST">
            <label for="username">Username:</label> <input type="text" name="username">
            <br />
            <label for="password">Password:</label> <input type="password" name="password">
            <br />
            <button type="submit">Submit</button>
        </form>

        <h1>Sign up:</h1>
        <form action="login.php?action=signup" name="signup" method="POST">
            <label for="username">Username:  <input type="text" name="username"></label>
            <br />
            <label for="password">Password: <input type="password" name="password"></label>
            <br />
            <label for="address">Address:  <input type="text" name="address"></label>
            <br />
            <button type="submit">Submit</button>
        </form>
    </body>
</html>

<?php

require_once __DIR__ . '/../App/global.php';

use App\Classes\DAO\UserMySQLDAO;
use App\Classes\UserService;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userDAO = new UserMySQLDAO($databaseConnection);
    $userService = new UserService($userDAO, $sessionManager);
    // Handle case when login is submitted
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            echo "login set";
            $loggedIn = $userService->login($_POST['username'], $_POST['password']);

            if ($loggedIn) {
                echo "logged in \n";
            }
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'signup') {
        // TODO - flip this so that it returns a specific error if one field is not set
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['address'])) {
            $user = $userService->create($_POST['username'], $_POST['password'], $_POST['address']);
            print_r($user);
        }
    }
}

?>

