<?php 

namespace App\Interfaces;

interface SessionManagerInterface {

    public function startSession($name, $limit = 0, $path = '/', $domain = null, $secure = null);

    public function preventHijacking();

    public function regenerateSession();

    public function validateSession($time);

    public function destroySession();
}

?>