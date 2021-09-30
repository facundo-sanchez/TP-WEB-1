
<?php

class SQLModel{
    protected $host = 'localhost';
    protected $db ='db_news';
    protected $user = 'root';
    protected $password = '';
    protected $connect;
    
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
