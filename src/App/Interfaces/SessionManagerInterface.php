<?php 

namespace App\Interfaces;

/**
 * Session manager interface
 */
interface SessionManagerInterface {

    /**
     * For easies starting a session and creating a cookie.
     */
    public function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null);

    /**
     * Updating current session ID with a new one.
     * 
     * @return bool if succeeded
     */
    public function regenerateSession();

    /**
     * Validates if current session is legit and still should exist.
     * 
     * @return bool true if session is valid and false if session isn't
     */
    public function validateSession();

    /**
     * Removing a session and its content.
     * 
     * @return bool true if success and false if not.
     */
    public function destroySession();
}