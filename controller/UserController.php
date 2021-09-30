<?php
require_once('./model/UserModel.php');
require_once('./view/NewsView.php');

class UserController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new UserModel();
        $this->view = new NewsView();
    }
    
    public function ShowUser(){
      $user = $this->model->UserLogin($_SESSION['email']);
      return $user;

    }

    public function showGetRegister($sesion){
        if($sesion === false){
            $this->view->renderRegister();
        }else{
            header('Location:'.admin);
        }
    }

    public function Register(){
        if(!empty($_POST)){
            $email = $_POST['user_email'];
            $password = password_hash($_POST['user_pass'],PASSWORD_BCRYPT);
    
            $validate = $this->model->SingUp($email,$password);
            
            if($validate === false){
                $this->view->RenderMessage('EMAIL REGISTERED','Email already registered');
            }else{
                $this->view->RenderMessage('Registered Email','The email has been registered correctly.');
            }
        }else{
            header('Location:'.BASE_URL);
        } 
    }

    public function showGetLogin($sesion){
        if($sesion === false){
            $this->view->renderLogin();
        }else{
            header('Location:'.admin);
        }
        
    }

    public function Login(){
        if(!empty($_POST)){
            $email = $_POST['user_email'];
            $password = $_POST['user_pass'];
    
            $user_data = $this->model->UserLogin($email);
     
            if($user_data && password_verify ($password,($user_data->password))){
                $_SESSION['login'] = true;
                $_SESSION['email'] = $email;
    
                header('Location:'.admin);
            }else{
                $this->view->RenderMessage('Login error','Email or password incorrect please try again');
            }
        }else{
            header('Location:'.BASE_URL);
        }
        

    }

    public function VerifySession(){
        
        if(isset($_SESSION['login']) && $_SESSION['login'] === true){
            return true;
        }
        
        return false;
    }
    public function ShowSingOff(){
    
        session_unset();
        session_destroy();

        header('Location:'.BASE_URL);
    }
}