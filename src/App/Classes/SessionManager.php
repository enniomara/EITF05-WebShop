<?php

namespace App\Classes;

use App\Interfaces\SessionManagerInterface;

class SessionManager implements SessionManagerInterface {

    private $timeout_duration = 1800;

    private $started = false;

    public function start() {
        $time = $_SERVER['REQUEST_TIME'];
        $this->validate();

        if ( !($this->isStarted()) ) {
            session_start();
            $this->started = true;
        }

        $_SESSION['LAST_ACTIVITY'] = $time;
    }

    private function isStarted() {
        return $this->started;
    }

    public function regenerate() {
        return session_regenerate_id();
    }

    public function validate() {
        // ToDo: Check so that parameters are okay.
        $time = $_SERVER['REQUEST_TIME'];
        if ( isset( $_SESSION['LAST_ACTIVITY'] ) && ( $time - $_SESSION['LAST_ACTIVITY'] ) > $this->timeout_duration ) {
            $this->destroy();

            return false;
        }

        return true;
    }

    public function destroy() {
        // ToDo: Remove PHPSESSID from browser (cookie)
        // Clear session from globals
        $_SESSION = array();
        session_unset();

        // Clear session from disk
        return session_destroy();
    }
}
