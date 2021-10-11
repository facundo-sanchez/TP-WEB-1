<?php

require_once('./view/NewsView.php');
require_once('./model/NewsModel.php');
require_once('./helper/AuthHelper.php');

class NewsController{
    private $model;
    private $view;
    private $auth;

    public function __construct(){
        $this->model = new NewsModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
    }
    
    //public access
    public function showNotFound($title,$error){
        $this->view->RenderMessage($title,$error);
    }

    public function showHome(){
        $news = $this->model->getNews();
        if(count($news) === 0){
            $this->view->RenderMessage('ERROR 404','Not found news');
        }else{
            $this->view->renderHome($news);
        }
    }

    public function showNews($id){
        $news = $this->model->getNewsId($id);
        if($news === false){
            $this->view->RenderMessage('ERROR 404','Not found news');
        }else{
            $this->view->renderNews($news);
        }
    }

    public function showFilter($id){
        $category_filter = $this->model->getFilter($id);
        if(empty($category_filter)){
            $this->view->RenderMessage('ERROR 404','Category or News not found');
        }else{
            $this->view->renderFilter($category_filter);
        }
    }
    
    //private access
    public function showAdminNews($category,$admin){
        $news = $this->model->getNews();
        $this->view->renderAdmin($news,$category,$admin);
    }

    //News
    public function showSendNews(){
        if($this->auth->VerifySession() === true){
            if(!empty($_POST)){
                $title = $_POST['title_news'];
                $category = $_POST['category_news'];
                $description = $_POST['description_news'];
                $this->model->sendNews($title,$category,$description);
            }else{
                header('Location:'.admin);
                die();
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }

    public function showConfirmUpdateNews($category,$id){
        if($this->auth->VerifySession() === true){
            $news = $this->model->getNewsId($id);
            if($news !=false){
                $this->view->renderConfirmUpdateNews($news,$category,false);
            }else{
                $this->view->RenderMessage('ERROR 404','News not found');
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }

    public function showUpdateNews(){
        if($this->auth->VerifySession() === true){
            if(!empty($_POST)){
                if(filter_var($_POST['id_news'],FILTER_VALIDATE_INT)){
                    $id_news = $_POST['id_news'];
                    $title_news = $_POST['title_news'];
                    $category_news = $_POST['category_news'];
                    $description_news = $_POST['description_news'];
                    $this->model->updateNews($id_news,$title_news,$category_news,$description_news);
                    $news = $this->model->getNewsId($id_news);
                    $this->view->renderConfirmUpdateNews($news,null,true);
                }else{
                    $this->view->RenderMessage('ERROR ID','Try it again later');
                }
               
            }else{
                header('Location:'.admin);
                die();
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }

    public function showConfirmDeleteNews($id){
        if($this->auth->VerifySession() === true){
            $news = $this->model->getNewsId($id);
            if($news !=false){
                $url = 'delete-news';
                $this->view->renderConfirm($id,$url,false);
            }else{
                $this->view->RenderMessage('ERROR 404','NEWS NOT FOUND');
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }

    public function showDeleteNews($id){
        if($this->auth->VerifySession() === true){
            if($id !=null){
                $news = $this->model->getNewsId($id);
                if($news != false){
                    $this->model->deleteNews($id);
                    $this->view->renderConfirm(0,0,true);
                }else{
                    $this->view->RenderMessage('ERROR 404','NEWS NOT FOUND');
                }
            }else{
                header('Location:'.admin);
                die();
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    } 

}