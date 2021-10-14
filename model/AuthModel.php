<?php
class AuthModel extends SQLModel{

    function __construct(){
       parent::__construct();
    }
    
    function SingUp($name,$surname,$email,$password){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            if($result === false){
                $query = $this->connect->prepare('INSERT INTO users (name,surname,email,password) VALUES (?,?,?,?)');
                $query->execute([$name,$surname,$email,$password]);
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            echo 'ERROR:'.$e->getMessage();
        }
        
    }

    function UserLogin($email){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $user = $query->fetch(PDO::FETCH_OBJ);
            return $user;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }
}