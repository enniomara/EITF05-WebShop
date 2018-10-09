<?php

namespace App\Classes;

use App\Classes\Models\User;
use App\Interfaces\SessionManagerInterface;
use Exception;

class SessionManager implements SessionManagerInterface
{
    // Cookie/session TTL, when no activity.
    private $timeoutDuration = 1800;

    /**
     * @inheritdoc
     */
    public function start(): bool
    {
        // Checking if session is allowed to start or if its already running
        if (session_status() == PHP_SESSION_DISABLED || session_status() == PHP_SESSION_ACTIVE) {
            return false;
        }

        // Starting session
        if (!session_start()) {
            throw new Exception("Couldn't start a session for some reason.");
        }

        // ToDo: Check if session is empty and initialize in a new method.

        if (!$this->validate()) {
            if ($this->destroy()) {
                $this->start();
            } else {
                throw new Exception("Unable to destroy the session.");
            }
        }

        // If it isn't set, we need to generate it
        $token = $this->getCSRFToken();
        if (isset($token) === false) {
            $this->generateCSRFToken();
        }

        $this->setActivityTime();

        return true;
    }

    /**
     * Sets last activity to request time.
     */
    private function setActivityTime()
    {
        $_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
    }

    /**
     * Set a user to the session.
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $_SESSION['authenticatedUser'] = [
            'userId' => $user->getUsername()
        ];
    }

    /**
     * Set cart to session
     *
     * @param Cart The cart with items
     */
    public function setCart(Cart $cart)
    {
        $_SESSION['CART'] = $cart;
    }

    /**
     * Checking if user is already set.
     *
     * @return bool if user is set
     */
    public function isUserSet(): bool
    {
        return isset($_SESSION['authenticatedUser']['userId']);
    }

    /**
     * Get the saved user from the session.
     *
     * The format of the array is
     * ```
     * [
     *  'userId' => $id
     * ]
     * ```
     *
     * @return array|null
     */
    public function getUser(): ?array
    {
        if (!$this->isUserSet()) {
            return null;
        }
        return $_SESSION['authenticatedUser'];
    }

    /**
     * Get the cart for this session
     *
     * @return Cart|null The set cart
     */
    public function getCart(): ?Cart
    {
        return $_SESSION['CART'] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function regenerate(): bool
    {
        $this->generateCSRFToken();
        return session_regenerate_id();
    }

    /**
     * @inheritdoc
     */
    public function validate(): bool
    {
        // ToDo: Check so that parameters are okay.
        $time = $_SERVER['REQUEST_TIME'];
        if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $this->timeoutDuration) {
            return false;
        }
        return true;
    }

    /**
     * Get the generated CSRF token.
     * @return string
     */
    public function getCSRFToken(): ?string
    {
        if (!isset($_SESSION['csrfToken'])) {
            return null;
        }
        return $_SESSION['csrfToken'];
    }

    /**
     * @inheritdoc
     */
    public function destroy(): bool
    {
        // Clear session from globals
        unset($_COOKIE['PHPSESSID']);
        // empty value and expiration one hour before
        setcookie('PHPSESSID', '', time() - 3600);

        session_unset();
        $_SESSION = [];
        // Clear session from disk
        return session_destroy();
    }

    /**
     * Generate a random string and set it as a CSRF token in session
     */
    private function generateCSRFToken(): void
    {
        $_SESSION['csrfToken'] = bin2hex(random_bytes(32));
    }

    /**
     * Put a key/value pair in the session.
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get an item from the session.
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Check if a key is stored inn the session.
     *
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $_SESSION);
    }
}
