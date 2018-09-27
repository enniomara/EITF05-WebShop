<?php 

namespace App\Classes;

use App\Interfaces\SessionManagerInterface;

class SessionManager implements SessionManagerInterface{

    static function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null){
        $time = $_SERVER['REQUEST_TIME'];
        self::validateSession($time);

        if(!session_start()) session_start();

        $_SESSION['LAST_ACTIVITY'] = $time;
        $_SESSION['name'] = $name;
    }

    static function preventHijacking(){}

    static function regenerateSession(){
        return session_regenerate_id();
    }

    static function validateSession($time){
        // ToDo: Check so that parameters are okay.
        if(isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > self::timeout_duration){
            self::destroySession();
        }
    }

    static function destroySession(){
        // ToDo: Remove PHPSESSID from browser (cookie)
        // Clear session from globals
        $_SESSION = array();
        session_unset();
        // Clear session from disk
        session_destroy();
    }
}
?>