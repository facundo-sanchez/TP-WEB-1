<?php

require_once('SQLModel.php');

class NewsModel extends SQLModel{

    function __construct(){
        parent::__construct();
    }
    
    //public acccess
    function getNews($page,$news_articles){
        try{
            $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id ORDER BY a.id DESC LIMIT :home,:news');
            $news->bindParam(':home',$page, PDO::PARAM_INT);
            $news->bindParam(':news',$news_articles, PDO::PARAM_INT);
            $news->execute();
            $result = $news->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }
    function countNews(){
        try{
            $news = $this->connect->prepare('SELECT COUNT(id) AS news FROM news');
            $news->execute();
            $result = $news->fetch(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function getNewsId($id){
        try{
            $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category,c.comment,c.points FROM news a LEFT JOIN categories b ON a.id_category = b.id LEFT JOIN comments c ON a.id = c.id_news WHERE a.id = ?');
            $news->execute([$id]);
            $result = $news->fetch(PDO::FETCH_OBJ);
            
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function getFilter($id){
        try{
            $category = $this->connect->prepare('SELECT a.id,a.title,a.description,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE b.category = ?');
            $category->execute([$id]);
            $result = $category->fetchAll(PDO::FETCH_OBJ);
            
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }
    
    function searchNews($params){
        //SELECT a.id,a.title,a.description,a.img,a.id_category,b.category,b.description FROM categories b LEFT JOIN news a ON a.id_category = b.id WHERE b.description LIKE "%loca%" OR b.category LIKE "%loca%"
        try{
            $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE a.title LIKE "%"?"%" AND a.description LIKE "%"?"%"');
            $news->execute([$params,$params]);
            $result = $news->fetchAll(PDO::FETCH_OBJ);
            if(empty($result)){
                $category = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category,b.description FROM categories b LEFT JOIN news a ON a.id_category = b.id WHERE b.description LIKE "%"?%"" OR b.category LIKE "%"?"%"');
                $category->execute([$params,$params]);
                $result = $category->fetchAll(PDO::FETCH_OBJ);
                var_dump($params);
            }
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    //access private
    //News ABM
    function sendNews($title,$category,$description,$img = null){
        $pathImg = null;
        if($img){
            $pathImg = $this->uploadImage($img);
            try{
                $news = $this->connect->prepare('INSERT INTO news (title,description,img,id_category) VALUES (?,?,?,?)');
                $news->execute([$title,$description,$pathImg,$category]);
            }catch(Exception $e){
                echo 'ERROR'.$e->getMessage();
            }
        }else{
            try{
                $news = $this->connect->prepare('INSERT INTO news (title,description,id_category) VALUES (?,?,?)');
                $news->execute([$title,$description,$category]);
            }catch(Exception $e){
                echo 'ERROR'.$e->getMessage();
            }
        }
        
    }
    function uploadImage($img){
        $target = 'images/news/'.uniqid().'.'. strtolower(pathinfo($img['name'],PATHINFO_EXTENSION));
        move_uploaded_file($img['tmp_name'],$target);
        return $target;
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
            //eliminar comentarios asociados con la noticia
            $query = $this->connect->prepare('DELETE FROM `comments` WHERE id_news = ?');
            $query->execute([$id]);
            
            $query = $this->connect->prepare('DELETE FROM news WHERE id = ?');
            $query->execute([$id]);
        }catch(Exception $e){
            echo 'ERRPR'.$e->getMessage();
        }

    }
/*
consulta de busqueda
SELECT * FROM `categories` WHERE (description LIKE '%%' OR category LIKE '%fut%')

*/
}