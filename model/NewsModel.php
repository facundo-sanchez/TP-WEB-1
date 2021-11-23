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
    function countNews($sql,$id){
        try{
            $news = $this->connect->prepare($sql);
            if($id !=null){
                $news->execute([$id]);
            }else{
                $news->execute();
            }
            $result = $news->fetch(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function getNewsId($id){
        try{
            $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id  WHERE a.id = ?');
            $news->execute([$id]);
            $result = $news->fetch(PDO::FETCH_OBJ);
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function getFilter($id,$page,$news_articles){
        try{

            $category = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE b.category = :id ORDER BY a.id DESC LIMIT :home,:news');
            $category->bindParam(':id',$id,PDO::PARAM_STR);
            $category->bindParam(':home',$page,PDO::PARAM_INT);
            $category->bindParam(':news',$news_articles,PDO::PARAM_INT);
            $category->execute();

            $result = $category->fetchAll(PDO::FETCH_OBJ);
            
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function searchNews($params){
        //SELECT a.id,a.title,a.description,a.img,a.id_category,b.category,b.description FROM categories b LEFT JOIN news a ON a.id_category = b.id WHERE b.description LIKE "%loca%" OR b.category LIKE "%loca%"
        try{
            $news = $this->connect->prepare('SELECT a.id,a.title,a.description,a.img,a.id_category,b.category,b.description AS description_category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE a.title LIKE "%":search"%" OR a.description LIKE "%":search"%" OR b.category LIKE "%":search"%" OR b.description LIKE "%":search"%"');
            $news->bindParam(':search',$params,PDO::PARAM_STR);
            $news->execute();
            $result = $news->fetchAll(PDO::FETCH_OBJ);

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

    function deleteImageNews($id){
        try{
            $query = $this->connect->prepare('UPDATE news SET img = ? WHERE id = ?');
            $query->execute([null,$id]);
        }catch(Exception $e){
            echo 'ERRPR'.$e->getMessage();
        }
    }

    function updateNews($id,$title,$category,$description,$img = null){
        $pathImg = null;
        if($img){
            $pathImg = $this->uploadImage($img);
            try{
                $query = $this->connect->prepare('UPDATE news SET title = ?, description = ?, img = ?, id_category = ? WHERE id = ?');
                $query->execute([$title,$description,$pathImg,$category,$id]);
            }catch(Exception $e){
                echo 'ERRPR'.$e->getMessage();
            }
        }else{
            try{
                $query = $this->connect->prepare('UPDATE news SET title = ?, description = ?, id_category = ? WHERE id = ?');
                $query->execute([$title,$description,$category,$id]);
            }catch(Exception $e){
                echo 'ERRPR'.$e->getMessage();
            }
        }
    }

    function UpdateCategoryNews($undefined,$id){
        try{
            $query= $this->connect->prepare('UPDATE news SET id_category = ? WHERE id_category = ?');
            $query->execute([$undefined->id,$id]);
            return true;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
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