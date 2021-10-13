<?php

require_once('SQLModel.php');

class CategoryModel extends SQLModel{
  
    function __construct(){
       parent::__construct();
    }

    function getCategory(){
        try{
            $category = $this->connect->prepare('SELECT * FROM categories');
            $category->execute();
            $result = $category->fetchAll(PDO::FETCH_OBJ);
    
            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function getCategoryID($id){
        try{
            $category = $this->connect->prepare('SELECT * FROM categories where id = ?');
            $category->execute([$id]);
            $result = $category->fetch(PDO::FETCH_OBJ);

            return $result;
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function sendCategory($category,$description){
        try{
         $query = $this->connect->prepare('INSERT INTO categories (category,description) VALUES (?,?)');
         $query->execute([$category,$description]);

        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
    }

    function updateCategory($id,$title,$description){
        try{
            $query= $this->connect->prepare('UPDATE categories SET category = ?, description = ? WHERE id = ?');
            $query->execute([$title,$description,$id]);
        }catch(Exception $e){
            echo 'ERRRO'.$e->getMessage();
        }   
    }

    function getUndefined(){
        $query = $this->connect->prepare('SELECT * FROM categories WHERE category = ?');
        $query->execute(['Undefined']);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    function deleteCategory($id,$undefined){
        try{
            //'SELECT * FROM categories WHERE id = ? || title = ?'
            $query= $this->connect->prepare('UPDATE news SET id_category = ? WHERE id_category = ?');
            $query->execute([$undefined->id,$id]);

            $query = $this->connect->prepare('DELETE FROM categories WHERE id = ?');
            $query->execute([$id]);
            
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }  
    }
}