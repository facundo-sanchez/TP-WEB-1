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
        $this->view->renderError($title,$error);
    }

    public function showHome(){
        $news = $this->model->getNews();
      
        if(count($news) === 0){
            var_dump($news);
            $this->view->renderError('ERROR 404','Not found news');
        }else{
            $this->view->renderHome($news);
        }
    }

    public function showNews($id){
        $news = $this->model->getNewsId($id);
      
        if($news === false){
            $this->view->renderError('ERROR 404','Not found news');
        }else{
            $this->view->renderNews($news);
        }
    }

    public function showFilter($id){
        $category_filter = $this->model->getFilter($id);

        if($category_filter == false){
            $this->view->renderError('ERROR 404','Category or News not found');
        }else{
            $this->view->renderFilter($category_filter);
        }
    }
    
    //private access
    public function showAdminNews($sesion,$category){
        //buscar categorias y noticias para update y delete
        if($sesion === true){
            $news = $this->model->getNews();
            $this->view->renderAdmin($news,$category);
        }else{
            header('Location:'.BASE_URL);
        }
        
    }

    //News
    public function showSendNews($sesion){
        $title = $_REQUEST['title_news'];
        $category = $_REQUEST['category_news'];
        $description = $_REQUEST['description_news'];

        $this->model->sendNews($title,$category,$description);
    }

    public function showConfirmUpdateNews($sesion,$id){
        $news = $this->model->getNewsId($id);
        $this->view->renderConfirmUpdateNews($news);
    }

    public function showUpdateNews($sesion){
        $id_news = $_REQUEST['id_news'];
        $title_news = $_REQUEST['title_news'];
        $category_news = $_REQUEST['category_news'];
        $description_news = $_REQUEST['description_news'];
       
        $this->model->updateNews($id_news,$title_news,$category_news,$description_news); 
    }

    public function showConfirmDeleteNews($sesion,$id){
        $url = 'delete-news';
        $this->view->renderConfirm($id,$url);
    }

    public function showDeleteNews($sesion,$id){
        //jacerlo con ajax para mostrar mensaje de eliminado.
        $this->model->deleteNews($id);
        header('Location:'.admin);
    } 



}