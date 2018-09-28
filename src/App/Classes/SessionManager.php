<?php 

namespace App\Classes;

use App\Interfaces\SessionManagerInterface;

class SessionManager implements SessionManagerInterface{

    const timeout_duration = 1800;

    public function startSession(){
        $time = $_SERVER['REQUEST_TIME'];
        $this->validateSession();

        if(!session_start()) session_start();

        $_SESSION['LAST_ACTIVITY'] = $time;
    }

    public function regenerateSession(){
        return session_regenerate_id();
    }

    public function validateSession(){
        // ToDo: Check so that parameters are okay.
        $time = $_SERVER['REQUEST_TIME'];
        if(isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $this->timeout_duration){
            $this->destroySession();
            return false;
        }

        return true;
    }

    public function destroySession(){
        // ToDo: Remove PHPSESSID from browser (cookie)
        // Clear session from globals
        $_SESSION = array();
        session_unset();
        // Clear session from disk
        return session_destroy();
    }
}