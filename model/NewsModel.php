<?php

class NewsModel{
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
    
    //public acccess
    function getNews(){
        //SELECT a.id,a.title,a.description,a.id_category,b.category FROM news a LEFT JOIN category b ON a.id_category = b.id
        $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id');
        $news->execute();
        $result = $news->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }

    function getNewsId($id){
        $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id  WHERE a.id = ?');
        $news->execute([$id]);
        $result = $news->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    function getFilter($id){
        $category = $this->connect->prepare('SELECT a.id,a.title,a.description,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE b.category = ?');
        $category->execute([$id]);
        $result = $category->fetchAll(pdo::FETCH_OBJ);
        
        return $result;
    }
    
    //access private

    //News ABM
    function sendNews($title,$category,$description){
        try{
            $news = $this->connect->prepare('INSERT INTO news (title,description,id_category) VALUES (?,?,?)');
            $news->execute([$title,$description,$category]);
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function updateNews($id,$title,$category,$description){
        try{
            $query = $this->connect->prepare('UPDATE news SET title = ?, description = ?, id_category = ? WHERE id = ?');
            $query->execute([$title,$description,$category,$id]);
        }catch(Exception $e){
            echo 'ERRPR'.$e->getMessage();
        }
    }

    function deleteNews($id){
        try{
            $query = $this->connect->prepare('DELETE FROM news WHERE id = ?');
            $query->execute([$id]);

        }catch(Exception $e){
            echo 'ERRPR'.$e->getMessage();
        }

    }
}