<?php

require_once __DIR__ . '/../App/global.php';

use App\Classes\View;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_POST['token'], $sessionManager->getCSRFToken())) {
        die('Token mismatch');
    }
    
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

$view = new View('login');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('CSRFToken', $sessionManager->getCSRFToken());
echo $view->render();

