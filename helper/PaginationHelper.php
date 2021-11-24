<?php
require_once('./model/PaginationModel.php');

class PaginationHelper{

    public $paging;
    private $model;

    function __construct(){
        $this->paging = 4;
        $this->model= new PaginationModel();
    }

    public function getPageNews($sql,$id){
        $get_count_page = $this->model->countNews($sql,$id);
        $page_count = ($get_count_page->news/$this->paging);
        return  ceil($page_count);
    }

    public function getHomePage($page){
        return ($page-1)*$this->paging;
    }
}