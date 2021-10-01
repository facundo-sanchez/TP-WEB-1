<?php
require_once('./model/AuthModel.php');
require_once('./view/NewsView.php');

class AuthController{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new AuthModel();
        $this->view = new NewsView();
    }

    public function VerifySession(){
        session_start();
        if(isset($_SESSION['login']) && $_SESSION['login'] === true){
            return true;
        }
        
        return false;
    }

    public function ShowUser(){
      $user = $this->model->UserLogin($_SESSION['email']);
      return $user;

    }

    public function showGetRegister($sesion){
        if($sesion === false){
            $this->view->renderRegister(null);
        }else{
            header('Location:'.admin);
            die();
        }
    }

    public function Register(){
        if(!empty($_POST)){
            $email = $_POST['user_email'];
            $password = password_hash($_POST['user_pass'],PASSWORD_BCRYPT);
    
            $validate = $this->model->SingUp($email,$password);
            
            if($validate === false){
                $this->view->renderRegister(true);
                //$this->view->RenderMessage('EMAIL REGISTERED','Email already registered');
            }else{
                $this->view->renderRegister(false);
               // $this->view->RenderMessage('Registered Email','The email has been registered correctly.');
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        } 
    }

    public function showGetLogin($sesion){
        if($sesion === false){
            $this->view->renderLogin(false);
        }else{
            header('Location:'.admin);
            die();
        }
        
    }

    public function Login(){
        if(!empty($_POST)){
            $email = $_POST['user_email'];
            $password = $_POST['user_pass'];
    
            $user_data = $this->model->UserLogin($email);
     
            if($user_data && password_verify ($password,($user_data->password))){
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user_data->id;
                $_SESSION['email'] = $user_data->email;
                
    
                header('Location:'.admin);
                die();
            }else{
                $this->view->renderLogin(true);
                //$this->view->RenderMessage('Login error','Email or password incorrect please try again');
            }
        }else{
            header('Location:'.BASE_URL);
            die();
        }
        

    }
    
    public function SingOff(){
        session_unset();
        session_destroy();

        header('Location:'.BASE_URL);
        die();
    }
}