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
        $query = $this->connect->prepare('INSERT INTO users (email,password) VALUES (?,?)');
        $query->execute([$email,$password]);
    }

    function UserLogin($email){
        //user login
        $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        
        return $user;
    }
}