<?php

use App\Classes\View;

require_once __DIR__ . '/../App/global.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$sessionManager->isUserSet()) {
        $flashMessageService->add('Cannot logout. No user is logged in.', \App\Interfaces\FlashMessageServiceInterface::ERROR);
        header('Location: /login.php');
        exit();
    }

    if (!hash_equals($_POST['token'], $sessionManager->getCSRFToken())) {
        $flashMessageService->add('Token mismatch', \App\Interfaces\FlashMessageServiceInterface::ERROR);
        header("Location: /logout.php");
        exit();
    }

    $userService->logout();
    header("Location: /login.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $view = new View('logout');
    $view->setAttribute('loggedInUser', $loggedInUser);
    $view->setAttribute('CSRFToken', $sessionManager->getCSRFToken());
    $view->setAttribute('flashMessages', $flashMessageService->getMessages());
    echo $view->render();
}

