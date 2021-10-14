<?php
require_once('./model/CategoryModel.php');
require_once('./view/NewsView.php');
require_once('./helper/AuthHelper.php');

class CategoryController{
    private $model;
    private $view;
    private $auth;

    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
    }

    //Category

    public function showCategory(){
        $category = $this->model->getCategory();
        return $category;
    }

    public function showHeader(){
        $category = $this->model->getCategory();
        $this->view->renderHeader($category);
    }

    public function showSendCategory(){
        if($this->auth->VerifySession() === true){
            if(!empty($_POST)){
                $category = $_POST['title_category'];
                $description = $_POST['description_category'];
                $this->model->sendCategory($category,$description);
            }else{
                header('Location:'.admin);
                die();
            }
        }else{
            header('Location:'.login);
            die();
        }
    }

    public function showConfirmUpdateCategory($id){
        if($this->auth->VerifySession() === true){
            $category = $this->model->getCategoryID($id);
            if($category != false){
                $this->view->renderConfirmUpdateCategory($category,false);
            }else{
                $this->view->RenderMessage('ERROR 404','Category not found');
            }
        }else{
            header('Location:'.login);
            die();
        }

    }

    public function showUpdateCategory(){
        if($this->auth->VerifySession() === true){
            if(!empty($_POST)){
                if(filter_var($_POST['id_category'],FILTER_VALIDATE_INT)){
                    $id_category = $_POST['id_category'];
                    $title_category = $_POST['title_category'];
                    $description_category = $_POST['description_category'];
                    $this->model->updateCategory($id_category,$title_category,$description_category);
                    $category = $this->model->getCategoryID($id_category);
                    $this->view->renderConfirmUpdateCategory($category,true);
                }else{
                    $this->view->RenderMessage('ERROR ID','Try it again later');
                }
               
            }else{
               header('Location:'.admin);
               die();
            }
        }else{
            header('Location:'.login);
            die();
        }
    }

    public function showConfirmDeleteCategory($id){
        if($this->auth->VerifySession() === true){
            $category = $this->model->getCategoryID($id);
            if($category != false){
                $url = 'delete-category';
                $this->view->renderConfirm($id,$url,false);
            }else{
                $this->view->RenderMessage('ERROR 404','CATEGORY NOT FOUND');
            }
           
        }else{
            header('Location:'.login);
            die();
        }
    }

    public function showDeleteCategory($id){
        if($this->auth->VerifySession() === true){
            if ($id != null){
                $undefined = $this->model->getUndefined();
                if($undefined === false){
                    $this->view->RenderMessage('ERROR 404','Category Undefined Not Found');
                }else{
                    $category = $this->model->getCategoryID($id);
                    if($category != false){
                        $this->model->deleteCategory($id,$undefined);
                        $this->view->renderConfirm(0,0,true);
                    }else{
                        $this->view->RenderMessage('ERROR 404','CATEGORY NOT FOUND');
                    }
                }
            }else{
               header('Location:'.admin);
               die();
            }
        }else{
            header('Location:'.login);
            die();
        }
    }
    /*
    public function showCategory(){
        $category = $this->model->getCategory();
        $this->view->renderHeader($category);
        $this->view->renderCategory($category);
    }
    */

}