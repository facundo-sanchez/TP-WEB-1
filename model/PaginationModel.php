<?php
require_once('./model/SQLModel.php');

class PaginationModel extends SQLModel{

    function __construct(){
        parent::__construct();
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
}