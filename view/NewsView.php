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
        $this->view->display('./template/header.tpl');
    }

    function renderHome($news){
        $this->view->assign('news',$news);
        $this->view->display('./template/news.tpl');
       
    }

    function renderNews($news){
        $this->view->assign('news',$news);
        $this->view->display('./template/viewnews.tpl');
    }

    /*
    function renderCategory($category){
        $this->view->assign('category',$category);
        $this->view->display('./temp/category.tpl');

    }
    */

    function renderFilter($category){
        $this->view->assign('news',$category);
        $this->view->display('./template/news.tpl');
       
    }

    function RenderMessage($title,$message){
        $this->view->assign('title',$title);
        $this->view->assign('message',$message);
        $this->view->display('./template/message.tpl');
      
    }

    //access private
    function renderRegister($error,$msg){
        $this->view->assign('error',$error);
        $this->view->assign('msg',$msg);
        $this->view->display('./template/register.tpl');
    }
    function renderLogin($error,$msg){
        $this->view->assign('error',$error);
        $this->view->assign('msg',$msg);
        $this->view->display('./template/login.tpl');
    }

    function renderAdmin($news,$category,$admin){
        $this->view->assign('news',$news);
        $this->view->assign('user',$admin);
        $this->view->assign('category',$category);
        $this->view->display('./template/admin.tpl');
    }

    function renderConfirmUpdateNews($news,$category,$success){
        $this->view->assign('news',$news);
        $this->view->assign('category',$category);
        $this->view->assign('success',$success);
        $this->view->display('./template/news-update.tpl');
    }

    function renderConfirmUpdateCategory($category,$success){
        $this->view->assign('cate',$category);
        $this->view->assign('success',$success);
        $this->view->display('./template/category-update.tpl');
    }

    function renderConfirm($id,$url,$delete){
        $this->view->assign('delete',$delete);
        $this->view->assign('id',$id);
        $this->view->assign('title','Delete News/Category');
        $this->view->assign('url',$url);
        $this->view->display('./template/confirm-delete.tpl');
    }
}