<?php

namespace App\Classes;

use App\Interfaces\SessionManagerInterface;

class CaptchaService
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var string Key used to authenticate against recaptcha. This is a test key given for testing purposes. This key
     * makes all validate requests return true. Should be changed to a real key in production.
     */
    private $captchaSecret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
    private $captchaSiteKey = "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI";

    public function __construct(SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    /**
     * Returns whether the captcha should show or not based on failed attempts.
     * @return bool
     */
    public function shouldShow()
    {
        $loginAttempts = $this->sessionManager->get('loginAttempts');

        if ($loginAttempts >= 2) {
            return true;
        }

        return false;
    }

    /**
     * Validate the response key retrieved from the captcha
     * @param $responseKey
     * @return bool
     */
    public function isValid(string $responseKey): bool
    {
        if (empty($responseKey)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'secret' => $this->captchaSecret,
            'response' => $responseKey,
        ));

        $resp = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($resp->success) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getCaptchaSiteKey(): string
    {
        return $this->captchaSiteKey;
    }

    /**
     * Increase the number of attempts that trigger captcha.
     * @return int The number of attempts stored.
     */
    public function increaseCaptchaAttempts(): int
    {
        $loginAttempts = $this->sessionManager->get('loginAttempts') ?? 0;
        $this->sessionManager->put('loginAttempts', ++$loginAttempts);
        return $loginAttempts;
    }

    /**
     * Reset captcha attempts to 0
     */
    public function resetCaptchaAttempts(): void
    {
        $this->sessionManager->put('loginAttempts', 0);
    }
}
