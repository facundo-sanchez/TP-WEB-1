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
      
    public function SingOff(){
        session_unset();
        session_destroy();
        header('Location:'.login);
        die();
    }
}