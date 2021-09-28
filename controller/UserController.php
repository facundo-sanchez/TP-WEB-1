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
    
    public function showRegister(){
        $email = $_POST['user_email'];
        $password = $_POST['user_pass'];
        
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
    public function ShowSingOff(){
       
        //session_unset();
        session_destroy();

        header('Location:'.BASE_URL);
    }
}