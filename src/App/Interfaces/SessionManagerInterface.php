<?php

namespace App\Interfaces;

/**
 * Session manager interface
 */
interface SessionManagerInterface {

    /**
     * For easies starting a session and creating a cookie.
     * 
     * @return bool if session was created
     * @throws Exception if session somehow didn't start
     */
    public function start();

    /**
     * Updating current session ID with a new one.
     *
     * @return bool if succeeded
     */
    public function regenerate();

    /**
     * Validates if current session is legit and still should exist.
     *
     * @return bool true if session is valid and false if session isn't
     */
    public function validate();

    /**
     * Removing a session and its content.
     *
     * @return bool true if success and false if not.
     */
    public function destroy();
}
