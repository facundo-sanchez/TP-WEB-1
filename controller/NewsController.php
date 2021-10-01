<?php

require_once('./view/NewsView.php');
require_once('./model/NewsModel.php');

class NewsController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new NewsModel();
        $this->view = new NewsView();
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
    public function showSendNews($sesion){
        if($sesion === true){
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

    public function showConfirmUpdateNews($sesion,$category,$id){
        if($sesion === true){
            $news = $this->model->getNewsId($id);
            if($news !=false){
                $this->view->renderConfirmUpdateNews($news,$category);
            }else{
                $this->view->RenderMessage('ERROR 404','News not found');
            }
           
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }

    public function showUpdateNews($sesion){
        if($sesion === true){

            if(!empty($_POST)){
                $id_news = $_POST['id_news'];
                $title_news = $_POST['title_news'];
                $category_news = $_POST['category_news'];
                $description_news = $_POST['description_news'];
               
                $this->model->updateNews($id_news,$title_news,$category_news,$description_news); 
            }else{
                header('Location:'.admin);
                die();
            }
           
        }else{
            header('Location:'.BASE_URL);
            die();
        }
     
    }

    public function showConfirmDeleteNews($sesion,$id){
        if($sesion === true){
            $url = 'delete-news';
            $this->view->renderConfirm($id,$url,false);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
      
    }

    public function showDeleteNews($sesion,$id){
        if($sesion === true){
            if($id !=null){
                $this->model->deleteNews($id);
                $this->view->renderConfirm(0,0,true);
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