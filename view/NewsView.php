<?php
require_once('./lib/smarty/libs/Smarty.class.php');

class NewsView{
    //public access
    private $view;

    function __construct(){
       $this->view = new Smarty();
        
    }

    function renderHeader($category,$sesion){
        $this->view->assign('category',$category);
        $this->view->assign('login',$sesion);
        $this->view->display('./temp/header.tpl');
    }

    function renderHome($news){
        $this->view->assign('news',$news);
        $this->view->display('./temp/news.tpl');
       
    }

    function renderNews($news){
        $this->view->assign('news',$news);
        $this->view->display('./temp/viewnews.tpl');
    }

    /*
    function renderCategory($category){
        $this->view->assign('category',$category);
        $this->view->display('./temp/category.tpl');

    }
    */

    function renderFilter($category){
        $this->view->assign('news',$category);
        $this->view->display('./temp/news.tpl');
       
    }

    function renderError($title,$error){
        $this->view->assign('title',$title);
        $this->view->assign('error',$error);
        $this->view->display('./temp/404.tpl');
      
    }

    //access private
    function renderRegister(){
        $this->view->display('./temp/register.tpl');
    }
    function renderLogin(){
        $this->view->display('./temp/login.tpl');
    }

    function showOut(){

    }

    function renderAdmin($news,$category,$admin){
        $this->view->assign('news',$news);
        $this->view->assign('user',$admin);
        $this->view->assign('category',$category);
        $this->view->display('./temp/admin.tpl');
    }

    function renderConfirmUpdateNews($news,$category){
        $this->view->assign('news',$news);
        $this->view->assign('category',$category);
        $this->view->display('./temp/news-update.tpl');
    }

    function renderConfirmUpdateCategory($category){
        $this->view->assign('cate',$category);
        $this->view->display('./temp/category-update.tpl');
    }

    function renderConfirm($id,$url){
        $this->view->assign('id',$id);
        $this->view->assign('title','Delete News/Category ');
        $this->view->assign('url',$url);
        $this->view->display('./temp/confirm.tpl');
    }
}