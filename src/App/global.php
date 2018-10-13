<?php

/**
 * Create all services used to run an application
 * E.g. a database connection, class autoloading
 */

require_once __DIR__ . '/../App/autoload.php';

use App\Classes\DAO\UserMySQLDAO;
use App\Classes\DBConnection;
use App\Classes\UserService;

$databaseConnection = new DBConnection();
$sessionManager = new \App\Classes\SessionManager();
$sessionManager->start();

$userService = new UserService(new UserMySQLDAO($databaseConnection), $sessionManager, new \App\Classes\PasswordService($databaseConnection));

$loggedInUser = null;
if ($sessionManager->getUser() !== null) {
    $loggedInUser = $userService->find($sessionManager->getUser()['userId']);
}

$flashMessageService = new \App\Classes\FlashMessageService($sessionManager);
