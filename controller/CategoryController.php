<?php
require_once('./model/CategoryModel.php');
require_once('./view/NewsView.php');

class CategoryController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new NewsView();
    }

    //Category

    public function showCategory(){
        $category = $this->model->getCategory();
        return $category;
    }

    /*
    public function showCategory(){
        $category = $this->model->getCategory();
        $this->view->renderHeader($category);
        $this->view->renderCategory($category);
    }
    */
    
    public function showHeader($sesion,$category){
        //var_dump($sesion);
        if($sesion === true){
            $this->view->renderHeader($category,$sesion);
        }else{
            $this->view->renderHeader($category,false);
        }
        
    }

    public function showSendCategory($sesion){
        if($sesion === true){
            
            if(!empty($_POST)){
                $category = $_REQUEST['title_category'];
                $description = $_REQUEST['description_category'];
                $this->model->sendCategory($category,$description);
            }else{
                header('Location:'.admin);
            }

        }else{
            header('Location:'.BASE_URL);
        }
       
    }

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
            if(!empty($_POST)){
                $id_category = $_REQUEST['id_category'];
                $title_category = $_REQUEST['title_category'];
                $description_category = $_REQUEST['description_category'];
        
                $this->model->updateCategory($id_category,$title_category,$description_category);
            }else{
               header('Location:'.admin);
            }
          
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
            if ($id != null){
                $success = $this->model->deleteCategory($id);
                if($success === false){
                    $this->view->renderError('ERROR 404','Category Undefined Not Found');
                }else{
                    header('Location:'.admin);
                }
            }
        }else{
            header('Location:'.BASE_URL);
        }
      
    }


}