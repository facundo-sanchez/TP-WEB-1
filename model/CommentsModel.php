<?php
require_once('./model/SQLModel.php');

class CommentsModel extends SQLModel{

    function __construct(){
        parent::__construct();
    }

    function getComments(){
        try{
            //SELECT a.comment,a.points,a.id_news,b.title,b.description,b.img,b.id_category,c.category FROM comments a LEFT JOIN news b ON a.id_news = b.id LEFT JOIN categories c ON b.id_category = c.id
            $query = $this->connect->prepare('SELECT a.id,a.comment,a.points,a.date,a.id_news,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_users = b.id ORDER BY id DESC');
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        
            return $result;

        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function getCommentsNewsId($id){
        try{
            $query = $this->connect->prepare('SELECT a.id,a.comment,a.points,a.date,a.id_news,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_users = b.id WHERE a.id_news = ? ORDER BY id DESC');
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

    function addComments($comment,$point,$date,$id_news,$id_user){
        try{
            $query = $this->connect->prepare('INSERT INTO comments (comment,points,date,id_news,id_users) VALUES (?,?,?,?,?)');
            $query->execute([$comment,$point,$date,$id_news,$id_user]);
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

    function deleteCommentsIdUser($id){
        try{
            $query = $this->connect->prepare('DELETE FROM comments WHERE id_users = ?');
            $query->execute([$id]);
            return true;
        }catch(Exception $e){
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    function deleteCommentsIdNews($id){
        try{
            $query = $this->connect->prepare('DELETE FROM comments WHERE id_news = ?');
            $query->execute([$id]);
            return true;
        }catch(Exception $e){
            echo 'ERROR: ' . $e->getMessage();
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

    function filterComments($id,$points){
        try{
            $query = $this->connect->prepare('SELECT a.id,a.comment,a.points,a.date,a.id_news,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_users = b.id WHERE points = ? AND a.id_news = ? ORDER BY date DESC');
            $query->execute([$points,$id]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }
    
}