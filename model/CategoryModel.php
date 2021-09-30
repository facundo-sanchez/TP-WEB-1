<?php

require_once('SQLModel.php');

class CategoryModel extends SQLModel{
  
    function __construct(){
       parent::__construct();
    }

    function getCategory(){
        $category = $this->connect->prepare('SELECT * FROM categories');
        $category->execute();
        $result = $category->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
    function getCategoryID($id){
        $category = $this->connect->prepare('SELECT * FROM categories where id = ?');
        $category->execute([$id]);
        $result = $category->fetch(PDO::FETCH_OBJ);

        return $result;
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
    function deleteCategory($id){
        try{
            $id_undefined = 5;
            //'SELECT * FROM categories WHERE id = ? || title = ?'
            $query = $this->connect->prepare('SELECT * FROM categories WHERE id IN (?)');
            $query->execute([$id_undefined]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            
            if($result === false){
                return false;
            }else{
                $query= $this->connect->prepare('UPDATE news SET id_category = ? WHERE id_category = ?');
                $query->execute([$id_undefined,$id]);
                $query = $this->connect->prepare('DELETE FROM categories WHERE id = ?');
                $query->execute([$id]);
                
            }
           
        }catch(Exception $e){
            echo 'ERROR'.$e->getMessage();
        }
        
    }
}