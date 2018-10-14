<?php

require_once __DIR__ . '/../App/global.php';

use App\Classes\View;

$captchaService = new \App\Classes\CaptchaService($sessionManager);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_POST['token'], $sessionManager->getCSRFToken())) {
        $flashMessageService->add('Token mismatch', \App\Interfaces\FlashMessageServiceInterface::ERROR);
        header("Location: /login.php");
        exit();
    }

    // Handle case when login is submitted
    if (isset($_GET['action']) && $_GET['action'] === 'login') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // Validate captcha
            if ($captchaService->shouldShow()) {
                if (false === $captchaService->isValid($_POST['g-recaptcha-response'])) {
                    $flashMessageService->add('Captcha was not valid.', \App\Interfaces\FlashMessageServiceInterface::ERROR);
                    header('Location: /login.php');
                    exit();
                }
            }


            try {
                $loggedIn = $userService->login($_POST['username'], $_POST['password']);
            } catch (\Exception $e) {
                $captchaService->increaseCaptchaAttempts();
                $flashMessageService->add($e->getMessage(), \App\Interfaces\FlashMessageServiceInterface::ERROR);
                header('Location: /login.php');
                exit();
            }

            if ($loggedIn) {
                $captchaService->resetCaptchaAttempts();
                $flashMessageService->add('Successfully logged in.', \App\Interfaces\FlashMessageServiceInterface::SUCCESS);
                header('Location: /home.php');
                exit();
            }
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'signup') {
        // All fields must be set, if one is empty throw error
        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['address'])) {
            $flashMessageService->add('One or more fields in signup form were not set.', \App\Interfaces\FlashMessageServiceInterface::ERROR);
            header('Location: /login.php');
            exit();
        }
        try {
            $user = $userService->create($_POST['username'], $_POST['password'], $_POST['address']);
        } catch (\Exception $e) {
            $flashMessageService->add($e->getMessage(), \App\Interfaces\FlashMessageServiceInterface::ERROR);
            header('Location: login.php');
            exit();
        }
        header('Location: /login.php');
        $flashMessageService->add('Successfully created user.', \App\Interfaces\FlashMessageServiceInterface::SUCCESS);
        exit();
    }
}

$view = new View('login');
$view->setAttribute('loggedInUser', $loggedInUser);
$view->setAttribute('CSRFToken', $sessionManager->getCSRFToken());
$view->setAttribute('flashMessages', $flashMessageService->getMessages());
$view->setAttribute('showCaptcha', $captchaService->shouldShow());
$view->setAttribute('captchaSiteKey', $captchaService->getCaptchaSiteKey());
echo $view->render();
