<?php

class AuthHelper{
    function __construct(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }
    public function VerifySession(){
        if(isset($_SESSION['login']) && $_SESSION['login'] === true){
            return true;
        }
        return false;
    }

    public function checkLoggedIn() {
        if (empty($_SESSION['user_id'])) {
            header('Location:'.login);
            die();
        }
    }
 
    public function SingOff(){
        session_unset();
        session_destroy();
        header('Location:'.login);
        die();
    }
}