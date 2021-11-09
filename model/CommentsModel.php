<?php
require_once('./model/SQLModel.php');

class CommentsModel extends SQLModel{

    function __construct(){
        parent::__construct();
    }

    function getComments(){
        try{
            //SELECT a.comment,a.points,a.id_news,b.title,b.description,b.img,b.id_category,c.category FROM comments a LEFT JOIN news b ON a.id_news = b.id LEFT JOIN categories c ON b.id_category = c.id
            $query = $this->connect->prepare('SELECT a.id,a.comment,a.points,a.id_news FROM comments a LEFT JOIN news b ON a.id_news = b.id LEFT JOIN categories c ON b.id_category = c.id ORDER BY a.id DESC');
            $query->execute([]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function getCommentsNewsId($id){
        try{
            $query = $this->connect->prepare('SELECT * FROM comments WHERE id_news = ? ORDER BY id DESC');
            $query->execute([$id]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function getCommentsId($id){
        try{
            $query = $this->connect->prepare('SELECT * FROM comments WHERE id = ?');
            $query->execute([$id]);
            $result = $query->fetch(PDO::FETCH_OBJ);
        
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function addComments($comment,$point,$date,$id_news){
        try{
            $query = $this->connect->prepare('INSERT INTO comments (comment,points,date,id_news) VALUES (?,?,?,?)');
            $query->execute([$comment,$point,$date,$id_news]);
            return $this->connect->lastInsertId();
            
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function deleteComments($id){
        try{
            $query = $this->connect->prepare('DELETE FROM comments WHERE id = ?');
            $query->execute([$id]);
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function orderComments($sql,$id){
        try{
            $query = $this->connect->prepare($sql);
            $query->execute([$id]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    //SELECT * FROM `comments` ORDER BY points DESC
    function filterComments($id,$points){
        try{
            $query = $this->connect->prepare('SELECT * FROM `comments` WHERE points = ? AND id_news = ?');
            $query->execute([$points,$id]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }
    
}