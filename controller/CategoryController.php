<?php
require_once('./model/CategoryModel.php');
require_once('./view/NewsView.php');
require_once('./helper/AuthHelper.php');
require_once('./helper/NewsHelper.php');

class CategoryController{
    private $model;
    private $view;
    private $auth;

    public function __construct(){
        $this->model = new CategoryModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
        $this->news = new NewsHelper();
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
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if(!empty($_POST['title_category'])&& !empty($_POST['description_category'])){
            $category = filter_var($_POST['title_category'],FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description_category'],FILTER_SANITIZE_STRING);
            $this->model->sendCategory($category,$description);
        }else{
            header('Location:'.admin);
            die();
        }
    }

    public function showConfirmUpdateCategory($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $category = $this->model->getCategoryID($id);
        if($category != false){
            $this->view->renderConfirmUpdateCategory($category,false);
        }else{
            $this->view->RenderMessage('ERROR 404','Category not found');
        }
    }

    public function showUpdateCategory(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if(!empty($_POST['id_category']) && !empty($_POST['title_category']) && !empty($_POST['description_category'])){
            $id_category = filter_var($_POST['id_category'],FILTER_SANITIZE_NUMBER_INT);
            $title_category = $_POST['title_category'];
            $description_category = $_POST['description_category'];
            $this->model->updateCategory($id_category,$title_category,$description_category);
            $category = $this->model->getCategoryID($id_category);
            $this->view->renderConfirmUpdateCategory($category,true);
        }else{
            header('Location:'.admin);
            die();
        }
    }

    public function showConfirmDeleteCategory($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if(filter_var($id,FILTER_SANITIZE_NUMBER_INT)){
            $category = $this->model->getCategoryID($id);
            if($category != false){
                $url = 'delete-category';
                $this->view->renderConfirm($id,$url,false);
            }else{
                $this->view->RenderMessage('ERROR 204','CATEGORY NOT FOUND');
            }
        }else{
            $this->view->RenderMessage('ERROR','ID NUMBER ERROR');
        }
       
           
    }

    public function showDeleteCategory($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if ($id != null){
            $undefined = $this->model->getUndefined();
            if($undefined === false){
                $this->view->RenderMessage('ERROR 204','Category Undefined Not Found');
            }else{
                $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
                $category = $this->model->getCategoryID($id);
                if($category != false){
                    $validate = $this->news->UpdateCategoryNews($undefined,$id);
                    if($validate){
                        $this->model->deleteCategory($id);
                        $this->view->renderConfirm(0,0,true);
                    }
                }else{
                    $this->view->RenderMessage('ERROR 204','CATEGORY NOT FOUND');
                }
                
              
            }
        }else{
            header('Location:'.admin);
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