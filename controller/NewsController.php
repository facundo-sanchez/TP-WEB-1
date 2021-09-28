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

    public function showHeader($sesion){
        $category = $this->model->getCategory();
        
        var_dump($sesion);
        if($sesion === false){
            $this->view->renderHeader($category,false);
        }else{
            $this->view->renderHeader($category,$_SESSION['login']);
        }
        
    }
    
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

    /*
    public function showCategory(){
        $category = $this->model->getCategory();
        $this->view->renderHeader($category);
        $this->view->renderCategory($category);
    }
    */

    public function showFilter($id){
        $category_filter = $this->model->getFilter($id);

        if($category_filter == false){
            $this->view->renderError('ERROR 404','Category or News not found');
        }else{
            $this->view->renderFilter($category_filter);
        }
    }
    
    //private access
    public function showRegister(){
        $email = $_POST['user_email'];
        $password = $_POST['user_pass'];
        
    }

    public function Register(){

    }

    public function showGetLogin(){
        $this->view->renderLogin();

    }
    public function Login(){
        $email = $_POST['user_email'];
        $password = $_POST['user_pass'];

        $user_data = $this->model->UserLogin($email);

        if($user_data && password_verify($password,($user_data->password))){
            $_SESSION['login'] = true;
            $_SESSION['user'] = $email;

            header('Location:'.admin);
        }else{
            $this->view->renderError('Login error','Email or password incorrect please try again');
        }

    }

    public function VerifySession(){
        
        if(isset($_SESSION['login']) && $_SESSION['login'] === true){
            return true;
        }
        
        return false;
    }

    public function showAdminNews($sesion){
        //buscar categorias y noticias para update y delete
        if($sesion === true){
            $category = $this->model->getCategory();
            $news = $this->model->getNews();
            $this->view->renderAdmin($news,$category);
        }else{
            header('Location:'.BASE_URL);
        }
        
    }

    //News
    public function showSendNews($sesion){
        if($sesion === true){
            $title = $_REQUEST['title_news'];
            $category = $_REQUEST['category_news'];
            $description = $_REQUEST['description_news'];
    
            $this->model->sendNews($title,$category,$description);
        }else{
            header('Location:'.BASE_URL);
        }
       
    }

    public function showConfirmUpdateNews($sesion,$id){
        if($sesion === true){
            $news = $this->model->getNewsId($id);
            $this->view->renderConfirmUpdateNews($news);
        }else{
            header('Location:'.BASE_URL);
        }

       
    }

    public function showUpdateNews($sesion){
        if($sesion === true){
            $id_news = $_REQUEST['id_news'];
            $title_news = $_REQUEST['title_news'];
            $category_news = $_REQUEST['category_news'];
            $description_news = $_REQUEST['description_news'];
           
            $this->model->updateNews($id_news,$title_news,$category_news,$description_news); 
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
        if($sesion === true){
             //jacerlo con ajax para mostrar mensaje de eliminado.
            $this->model->deleteNews($id);
            header('Location:'.admin);
        }else{
            header('Location:'.BASE_URL);
        }

       

    } 

    //Category
    public function showConfirmUpdateCategory($sesion,$id){
        if($sesion === true){
            $category = $this->model->getCategoryID($id);
            $this->view->renderConfirmUpdateCategory($category);
        }else{
            header('Location:'.BASE_URL);
        }

    }

    public function showUpdateCategory($sesion){
        if($sesion === true){
            $id_category = $_REQUEST['id_category'];
            $title_category = $_REQUEST['title_category'];
            $description_category = $_REQUEST['description_category'];
    
            $this->model->updateCategory($id_category,$title_category,$description_category);
        }else{
            header('Location:'.BASE_URL);
        }
       
    }

    public function showSendCategory($sesion){
        if($sesion === true){
            $category = $_REQUEST['title_category'];
            $description = $_REQUEST['description_category'];
    
            $this->model->sendCategory($category,$description);
        }else{
            header('Location:'.BASE_URL);
        }
       
    }

    public function showConfirmDeleteCategory($sesion,$id){
        if($sesion === true){
            $url = 'delete-category';
            $this->view->renderConfirm($id,$url);
        }else{
            header('Location:'.BASE_URL);
        }
       
    }

    public function showDeleteCategory($sesion,$id){
        if($sesion === true){
            $success = $this->model->deleteCategory($id);
            if($success === false){
                $this->view->renderError('ERROR 404','Category Undefined Not Found');
            }else{
                header('Location:'.admin);
            }
        }else{
            header('Location:'.BASE_URL);
        }
      
    }
    public function ShowSingOff(){
       
        //session_unset();
        session_destroy();

        header('Location:'.BASE_URL);
    }

}