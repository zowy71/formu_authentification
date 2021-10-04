<?php declare(strict_types=1);

class Session {

    public function start()
    {
        if (session_status() == PHP_SESSION_ACTIVE){
            session_start();
        }
        if (session_status() != PHP_SESSION_ACTIVE || headers_sent() == false){
            throw new SessionException();
        }
    }

}