<?php

/**
 * Create all services used to run an application
 * E.g. a database connection, class autoloading
 */

require_once __DIR__ . '/../App/autoload.php';

use App\Classes\DBConnection;

$databaseConnection = new DBConnection();
$sessionManager = new \App\Classes\SessionManager();
$sessionManager->start();
