<?php 

namespace App\Interfaces;

interface SessionManagerInterface {

    static function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null);

    static function preventHijacking();

    static function regenerateSession();

    static function validateSession($time);

    static function destroySession();
}

?>