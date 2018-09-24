<?php 

namespace App\Interfaces;

interface SessionManagerInterface {

    static function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null);

    static function stopHijack();

    static function regenerateSession();

    static function validateSession();
}

?>