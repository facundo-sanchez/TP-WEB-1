<?php

require_once('./view/NewsView.php');
require_once('./model/NewsModel.php');
require_once('./helper/AuthHelper.php');
require_once('./controller/AuthController.php');

class NewsController{
    private $model;
    private $view;
    private $auth;
    private $users;

    public function __construct(){
        $this->model = new NewsModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
        $this->users = new AuthController();
    }
    
    //public access
    public function showNotFound($title,$error){
        $this->view->RenderMessage($title,$error);
    }
    public function getPageNews(){
        $get_count_page = $this->model->countNews();
        $page_count = ($get_count_page->news/4);
        return  ceil($page_count);
    }
    public function showHome($page){
        $page_count = $this->getPageNews();
        $home = ($page-1)*4;

        $news = $this->model->getNews($home,4);
       

        if(count($news) === 0){
            $this->view->RenderMessage('Ups!','Not found news');
        }else{
            $this->view->renderHome($news,$page,$page_count);
        }
    }

    public function showNews($id){
        if(filter_var($id,FILTER_VALIDATE_INT)){
            $news = $this->model->getNewsId($id);

            if($news === false){
                $this->view->RenderMessage('ERROR 404','Not found news');
            }else{
                $this->view->renderNews($news);
            }
        }else{
            $this->view->RenderMessage('ERROR 404','Not found news');
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
    
    public function showSearch($page = null){
        if(!empty($_POST)){
            $search = $_POST['input_search'];
            $get_count_page = $this->model->countSearch($search);
           
            $page_count = $get_count_page->news/4;
            $home = ($page-1)*4;
            $news = $this->model->searchNews($search,$home,4);
            var_dump($news);
            if(!empty($news)){
                $this->view->renderHome($news,0,0);
            }else{
                $this->view->RenderMessage('No Search Results','Not found news or Categories');
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }
    
    //private access
    public function showAdminNews($category,$admin,$page = null){
        if(isset($page)){
            $page = 1;
        }
        if(filter_var($page,FILTER_VALIDATE_INT)){
            $this->auth->checkAdmin();
            $page_count = $this->getPageNews();
            $home = ($page-1)*4;
               
            $news = $this->model->getNews($home,4);
            $users = $this->users->getUsers($_SESSION['user_id']);
    
            $this->view->renderAdmin($news,$category,$admin,$users,$page,$page_count);
        }
       
       
    }

    //News
    public function showSendNews(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        
        if(!empty($_POST)){
            $title = $_POST['title_news'];
            $category = $_POST['category_news'];
            $description = $_POST['description_news'];
            if(!empty($_FILES['input_file']['name'])){
                var_dump($_FILES);
                if($_FILES['input_file']['type'] == "image/jpg" || $_FILES['input_file']['type'] == "image/jpeg" || $_FILES['input_file']['type'] == "image/png" ) {
                    $this->model->sendNews($title,$category,$description,$_FILES['input_file']);
                }else{
                    //hacer vista de enviado porq con ajax no me envia la imagen xd
                    $this->model->sendNews($title,$category,$description,null);
                }
            }else{
                $this->model->sendNews($title,$category,$description,null);
            }
        }else{
            header('Location:'.admin);
            die();
        } 
    }
   
    public function showConfirmUpdateNews($category,$id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $news = $this->model->getNewsId($id);
        if($news !=false){
            $this->view->renderConfirmUpdateNews($news,$category,false);
        }else{
            $this->view->RenderMessage('ERROR 404','News not found');
        }
      
    }

    public function showUpdateNews(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
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
        
    }

    public function showConfirmDeleteNews($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $news = $this->model->getNewsId($id);
        if($news !=false){
            $url = 'delete-news';
            $this->view->renderConfirm($id,$url,false);
        }else{
            $this->view->RenderMessage('ERROR 404','NEWS NOT FOUND');
        }
      
    }

    public function showDeleteNews($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
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
      
    } 

}