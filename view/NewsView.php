<?php
require_once('./lib/smarty/libs/Smarty.class.php');

class NewsView{
    //public access
    private $view;

    function __construct(){
       $this->view = new Smarty();
        
    }

    function renderHeader($category){
        $this->view->assign('category',$category);
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

    function RenderMessage($title,$message){
        $this->view->assign('title',$title);
        $this->view->assign('message',$message);
        $this->view->display('./temp/message.tpl');
      
    }

    //access private
    function renderRegister($error){
        $this->view->assign('error',$error);
        $this->view->display('./temp/register.tpl');
    }
    function renderLogin($error){
        $this->view->assign('error',$error);
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

    function renderConfirmUpdateNews($news,$category,$success){
        $this->view->assign('news',$news);
        $this->view->assign('category',$category);
        $this->view->assign('success',$success);
        $this->view->display('./temp/news-update.tpl');
    }

    function renderConfirmUpdateCategory($category,$success){
        $this->view->assign('cate',$category);
        $this->view->assign('success',$success);
        $this->view->display('./temp/category-update.tpl');
    }

    function renderConfirm($id,$url,$delete){
        $this->view->assign('delete',$delete);
        $this->view->assign('id',$id);
        $this->view->assign('title','Delete News/Category');
        $this->view->assign('url',$url);
        $this->view->display('./temp/confirm.tpl');
    }
}