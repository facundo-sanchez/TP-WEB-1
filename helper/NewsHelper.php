<?php 
require_once('./controller/NewsController.php');

class NewsHelper{
    private $news;

    public function __construct(){
        $this->news = new NewsController();
    }

    public function UpdateCategoryNews($undefined,$id){
        $delete = $this->news->UpdateCategoryNews($undefined,$id);
        return $delete;
    }
 

}