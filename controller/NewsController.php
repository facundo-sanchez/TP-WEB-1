<?php

require_once('./view/NewsView.php');
require_once('./model/NewsModel.php');
require_once('./helper/AuthHelper.php');
require_once('./helper/CommentsHelper.php');

class NewsController{
    private $model;
    private $view;
    private $auth;
    private $comments;

    public function __construct(){
        $this->model = new NewsModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
        $this->comments = new CommentsHelper();
    }
    
    //public access
    public function showNotFound($title,$error){
        $this->view->RenderMessage($title,$error);
    }

    public function getPageNews($sql,$id){
        $get_count_page = $this->model->countNews($sql,$id);
        $page_count = ($get_count_page->news/4);
        return  ceil($page_count);
    }

    public function showHome($page){
        $page = filter_var($page,FILTER_SANITIZE_NUMBER_INT);
        if(!filter_var($page,FILTER_VALIDATE_INT)){
            $page = 1;
        }
        $page_count = $this->getPageNews('SELECT COUNT(id) AS news FROM news',null);
        $home = ($page-1)*4;

        $news = $this->model->getNews($home,4);
       
        if(empty($news)){
            $this->view->RenderMessage('Ups!','Not found news');
        }else{
            $this->view->renderHome($news,$page,$page_count);
        }
    }

    public function showNews($id){
        if(filter_var($id,FILTER_VALIDATE_INT)){
            $news = $this->model->getNewsId($id);
            if($news === false){
                $this->view->RenderMessage('ERROR 204','Not found news');
            }else{
                $this->view->renderNews($news);
            }
        }else{
            $this->view->RenderMessage('ERROR 204','Not found news');
        }
    }

    public function showFilter($id,$page){
        $page =  filter_var($page,FILTER_SANITIZE_NUMBER_INT);
        if(!filter_var($page,FILTER_VALIDATE_INT)){
           $page = 1;
        }
        $page_count = $this->getPageNews('SELECT COUNT(a.id) AS news, a.id,a.id_category,b.category FROM news a LEFT JOIN categories b ON a.id_category = b.id WHERE b.category = ?',$id);
        $home = ($page-1)*4;
        $category_filter = $this->model->getFilter($id,$home,4);

        if(empty($category_filter)){
            $this->view->RenderMessage('ERROR 204','Category or News not found');
        }else{
            $this->view->renderFilter($id,$category_filter,$page,$page_count);
        }
    }
    
    public function showSearch(){
        if(!empty($_POST['input_search'])){
            $search = filter_var($_POST['input_search'] ,FILTER_SANITIZE_STRING);

            $news = $this->model->searchNews($search);
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
    public function showAdminNews($category,$admin,$page){
        $page = filter_var($page,FILTER_SANITIZE_NUMBER_INT);
        if(!filter_var($page,FILTER_VALIDATE_INT)){
           $page = 1;
        }
        $this->auth->checkAdmin();
        $page_count = $this->getPageNews('SELECT COUNT(id) AS news FROM news',null);
        $home = ($page-1)*4;
    
        $news = $this->model->getNews($home,4);
             
        $users = $this->auth->getUsers($_SESSION['user_id']);
        if(!empty($users)){
            $this->view-> renderAdmin($news,$category,$admin,$users,$page,$page_count);
        } else{
            $this->view-> renderAdmin($news,$category,$admin,null,$page,$page_count);
        }   
        
    }

    //News
    public function showSendNews(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        
        if(!empty($_POST['title_news']) && !empty($_POST['category_news']) && !empty($_POST['description_news'])){
            $title = filter_var($_POST['title_news'] ,FILTER_SANITIZE_STRING);
            $category = filter_var($_POST['category_news'] ,FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description_news'] ,FILTER_SANITIZE_STRING);
            if(!empty($_FILES['input_file']['name'])){
                if($_FILES['input_file']['type'] == "image/jpg" || $_FILES['input_file']['type'] == "image/jpeg" || $_FILES['input_file']['type'] == "image/png" ) {
                    $this->model->sendNews($title,$category,$description,$_FILES['input_file']);
                    $this->view->RenderMessage('Success','News Posted');
                }else{
                    $this->model->sendNews($title,$category,$description,null);
                    $this->view->RenderMessage('Success','News Posted');
                }
            }else{
                $this->model->sendNews($title,$category,$description,null);
                $this->view->RenderMessage('Success','News Posted');
            }
        }else{
            header('Location:'.admin);
            die();
        } 
    }
   
    public function showConfirmUpdateNews($category,$id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $id =  filter_var($id,FILTER_SANITIZE_NUMBER_INT);
        $news = $this->model->getNewsId($id);
        if($news !=false){
            $this->view->renderConfirmUpdateNews($news,$category,false);
        }else{
            $this->view->RenderMessage('ERROR 204','News not found');
        }
      
    }

    public function showUpdateNews(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if(!empty($_POST['title_news']) && !empty($_POST['category_news'])  && !empty($_POST['description_news'])){
            $id_news = filter_var($_POST['id_news'],FILTER_SANITIZE_NUMBER_INT);
            $title_news =filter_var($_POST['title_news'],FILTER_SANITIZE_STRING);
            $category_news = filter_var($_POST['category_news'],FILTER_SANITIZE_STRING);
            $description_news = filter_var($_POST['description_news'],FILTER_SANITIZE_STRING);
           
            if(!empty($_FILES['input_file']['name'])){
                if($_FILES['input_file']['type'] == "image/jpg" || $_FILES['input_file']['type'] == "image/jpeg" || $_FILES['input_file']['type'] == "image/png" ) {

                $this->model->updateNews($id_news,$title_news,$category_news,$description_news,$_FILES['input_file']);
                }else{
                    $this->model->updateNews($id_news,$title_news,$category_news,$description_news,null);
                }
            }else{
                $this->model->updateNews($id_news,$title_news,$category_news,$description_news,null);
            }
            $news = $this->model->getNewsId($id_news);
            $this->view->renderConfirmUpdateNews($news,null,true);

               
        }else{
            header('Location:'.admin);
            die();
        }    
        
    }

    public function UpdateCategoryNews($undefined,$id){
        $delete = $this->model->UpdateCategoryNews($undefined,$id);
        return $delete;
    }

    public function showConfirmDeleteNews($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
        $news = $this->model->getNewsId($id);
        if($news !=false){
            $url = 'delete-news';
            $this->view->renderConfirm($id,$url,false);
        }else{
            $this->view->RenderMessage('ERROR 204','NEWS NOT FOUND');
        }

    }

    public function showDeleteImage($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if($id !=null){
            $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            $news = $this->model->getNewsId($id);
            if($news != false){
                $this->model->deleteImageNews($id);
                $this->view->renderConfirm(0,0,true);
            }else{
                $this->view->RenderMessage('ERROR 204','IMAGE NOT FOUND');
            }
        }else{
            header('Location:'.admin);
            die();
        }
    }

    public function showDeleteNews($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
        if($id !=null){
            $news = $this->model->getNewsId($id);
            if($news != false){
                $deleteComments = $this->comments->deleteCommentsIdNews($id);
                if($deleteComments){
                    $this->model->deleteNews($id);
                    $this->view->renderConfirm(0,0,true);
                }
            }else{
                $this->view->RenderMessage('ERROR 204','NEWS NOT FOUND');
            }
        }else{
            header('Location:'.admin);
            die();
        }
        
    } 

}