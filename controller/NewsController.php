<?php

/*
seguridad en delete,update,send terminado
Notas -> Buscar errores de sesion
simplificar codigo (SI PUEDO HACER HERENCIA DE SQL)


*/


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
       
        if(empty($category_filter)){
            $this->view->renderError('ERROR 404','Category or News not found');
        }else{
            $this->view->renderFilter($category_filter);
        }
    }
    
    //private access
    public function showAdminNews($category,$admin){
        //buscar categorias y noticias para update y delete
        $news = $this->model->getNews();
        $this->view->renderAdmin($news,$category,$admin);
    }

    //News
    public function showSendNews($sesion){
        if($sesion === true){
            if(!empty($_POST)){
                $title = $_REQUEST['title_news'];
                $category = $_REQUEST['category_news'];
                $description = $_REQUEST['description_news'];
        
                $this->model->sendNews($title,$category,$description);
            }else{
                header('Location:'.admin);
            }

        }else{
            header('Location:'.BASE_URL);
        }
      
    }

    public function showConfirmUpdateNews($sesion,$category,$id){
        if($sesion === true){
            $news = $this->model->getNewsId($id);
            $this->view->renderConfirmUpdateNews($news,$category);
        }else{
            header('Location:'.BASE_URL);
        }

       
    }

    public function showUpdateNews($sesion){
        if($sesion === true){
            if(!empty($_POST)){
                $id_news = $_REQUEST['id_news'];
                $title_news = $_REQUEST['title_news'];
                $category_news = $_REQUEST['category_news'];
                $description_news = $_REQUEST['description_news'];
               
                $this->model->updateNews($id_news,$title_news,$category_news,$description_news); 
            }else{
                header('Location:'.admin);
            }
           
        }else{
            header('Location:'.BASE_URL);
        }
     
    }

    public function showConfirmDeleteNews($sesion,$id){
        if($sesion === true){
            $url = 'delete-news';
            $this->view->renderConfirm($id,$url);
        }else{
            header('Location:'.BASE_URL);
        }
      
    }

    public function showDeleteNews($sesion,$id){
        //jacerlo con ajax para mostrar mensaje de eliminado.
        if($sesion === true){
            $this->model->deleteNews($id);
            header('Location:'.admin);
        }else{
            header('Location:'.BASE_URL);
        }
    } 

}