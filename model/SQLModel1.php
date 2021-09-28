
<?php

class SQLModel{
    private $host = 'localhost';
    private $db ='db_news';
    private $user = 'root';
    private $password = '';
    private $connect;
    
    public function __construct(){
        $connectSQL = "mysql:host=$this->host;"."dbname=$this->db;charset=utf8";
        try{
            $this->connect = new PDO($connectSQL,$this->user,$this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }
}
