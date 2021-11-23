<?php
require_once('./model/AuthModel.php');
require_once('./view/NewsView.php');
require_once('./helper/AuthHelper.php');
require_once('./helper/CommentsHelper.php');

class AuthController{
    private $model;
    private $view;
    private $auth;
    private $comments;

    public function __construct(){
        $this->model = new AuthModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
        $this->comments = new CommentsHelper();
    }

    public function checkLogged(){
        $this->auth->checkLoggedIn();
    }

    public function ShowUser(){
      $user = $this->model->UserLogin($_SESSION['email']);
      return $user;
    }

    public function Register(){
        if($this->auth->VerifySession()=== false){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['user_name']) && !empty($_POST['user_surname']) && !empty($_POST['user_email']) && !empty($_POST['user_pass']) && !empty($_POST['user_repeat_pass'])){
                    $name = filter_var($_POST['user_name'],FILTER_SANITIZE_STRING);
                    $surname = filter_var($_POST['user_surname'],FILTER_SANITIZE_STRING);
                    $email = filter_var($_POST['user_email'],FILTER_SANITIZE_EMAIL);
                    $password = password_hash($_POST['user_pass'],PASSWORD_BCRYPT);
                    $repeat_password = $_POST['user_repeat_pass'];

                    if(strlen($name) >150 || strlen($surname) >150){
                        $this->view->renderRegister(true,'First or Last name exceeds character limits');
                    }else if(strlen($email) >255 || strlen($password) >255){
                        $this->view->renderRegister(true,'Email or Password exceed the character limits');
                    }else if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                        if(password_verify($repeat_password,$password)){
                            $validate = $this->model->SingUp($name,$surname,strtolower($email),$password);
                          
                            if($validate === false){
                                $this->view->renderRegister(true,'Email already registered!');
                            }else if($validate === true){
                                $this->view->renderRegister(false,null);
                            }
                        }else{
                            $this->view->renderRegister(true,'Passwords do not match!');
                        }  
                    }else{
                        $this->view->renderRegister(true,'Email incorrect');
                    }
                }else{
                    header('Location:'.BASE_URL);
                    die();
                } 
            }else{
                $this->view->renderRegister(null,null);
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }   
    }

    public function Login(){
        if($this->auth->VerifySession() === false){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST['user_email']) && !empty($_POST['user_pass'])){
                    $email = filter_var($_POST['user_email'],FILTER_SANITIZE_EMAIL);
                    $password = $_POST['user_pass'];
                   
                    if(strlen($email) >255 || strlen($password) >255){
                        $this->view->renderLogin(true,'Email or Password exceed the character limits');
                    }else{
                        $user_data = $this->model->UserLogin($email);
                        if($user_data && password_verify ($password,($user_data->password))){
                            $_SESSION['login'] = true;
                            $_SESSION['role'] = $user_data->role;
                            $_SESSION['user_id'] = $user_data->id;
                            $_SESSION['name'] = $user_data->name;
                            $_SESSION['surname'] = $user_data->surname;
                            $_SESSION['email'] = $user_data->email;
                            $_SESSION['password'] = $user_data->password;
                          
                            header('Location:'.BASE_URL);
                            die();
                        }else{
                            $this->view->renderLogin(true,'Email or Password to incorrect!');  
                        }
                    }
                   
                }else{
                    header('Location:'.BASE_URL);
                    die();
                }
            }else{
                $this->view->renderLogin(null,null);
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
    }
    public function userAdminRole($id,$option){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $users = $this->model->getUsersId($id);

        if($users != false){
            if($option == 'update'){
                if($id != $_SESSION['user_id']){
                    $this->model->userAdmin($id);
                    $this->view->RenderMessage('Success','Admin added');
                }else{
                    $this->view->RenderMessage('Error','Admin no added');
                }
            }elseif($option == 'remove'){
                if($id != $_SESSION['user_id']){
                    $this->model->userDeleteAdmin($id);
                    $this->view->RenderMessage('Success','Admin removed');
                }else{
                    $this->view->RenderMessage('Error','Admin no remove');
                }
            }else{
                $this->view->RenderMessage('ERROR','Option not found');
            }
            
        }else{
            $this->view->RenderMessage('ERROR','User not remove');
        }
      
    }
    public function showConfirmDeleteUser($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if($id != $_SESSION['user_id']){
            $users = $this->model->getUsersId($id);
            if($users != false){
                $url = 'delete-users';
                $this->view->renderConfirm($id,$url,false);
            }else{
                $this->view->RenderMessage('ERROR','User not found');
            }
        }else{
            $this->view->RenderMessage('ERROR','User no deleted');
        }
    }

    public function userDelete($id){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        if($id != $_SESSION['user_id']){
            $users = $this->model->getUsersId($id);
            if($users != false){
                $deleteComments = $this->comments->deleteCommentsIdUser($id);
                if($deleteComments){
                    $this->model->userDelete($id);
                    $this->view->renderConfirm(0,0,true);
                }
            }else{
                $this->view->RenderMessage('ERROR','User no deleted');
            }
        }else{
            $this->view->RenderMessage('ERROR','User no deleted');
        }
        
    }
    
    public function SingOff(){
        $this->auth->SingOff();
    }
  
}