<?php
class UserModel{
    private $host = 'localhost';
    private $db ='db_news';
    private $user = 'root';
    private $password = '';
    private $connect;

    function __construct(){
        $connectSQL = "mysql:host=$this->host;"."dbname=$this->db;charset=utf8";
        try{
            $this->connect = new PDO($connectSQL,$this->user,$this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }
    
    function SingUp($email,$password){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $result = $query->fetch(PDO::FETCH_OBJ);

            if($result === false){
                $query = $this->connect->prepare('INSERT INTO users (email,password) VALUES (?,?)');
                $query->execute([$email,$password]);
                return true;
            }else{
                return false;
            }
          
        }catch(Exception $e){
            echo 'ERROR:'.$e->getMessage();
        }
        
    }

    function UserLogin($email){
        //user login
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $user = $query->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
      
        
        return $user;
    }
}