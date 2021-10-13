<?php
require_once('./model/AuthModel.php');
require_once('./view/NewsView.php');
require_once('./helper/AuthHelper.php');

class AuthController{
    private $model;
    private $view;
    private $auth;

    public function __construct(){
        $this->model = new AuthModel();
        $this->view = new NewsView();
        $this->auth = new AuthHelper();
    }

    public function checkLogged(){
       return  $this->auth->VerifySession();
    }

    public function ShowUser(){
      $user = $this->model->UserLogin($_SESSION['email']);
      return $user;
    }

    public function Register(){
        if($this->auth->VerifySession()=== false){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST)){
                    $name = $_POST['user_name'];
                    $surname = $_POST['user_surname'];
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
            header('Location:'.admin);
            die();
        }   
    }

    public function Login(){
        //VALIDAR LOGIN
        if($this->auth->VerifySession() === false){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST)){
                    $email = filter_var($_POST['user_email'],FILTER_SANITIZE_EMAIL);
                    $password = $_POST['user_pass'];
                   
                    if(strlen($email) >255 || strlen($password) >255){
                        $this->view->renderLogin(true,'Email or Password exceed the character limits');
                    }else{
                        $user_data = $this->model->UserLogin($email);
                        if($user_data && password_verify ($password,($user_data->password))){
                            $_SESSION['login'] = true;
                            $_SESSION['user_id'] = $user_data->id;
                            $_SESSION['name'] = $user_data->name;
                            $_SESSION['surname'] = $user_data->surname;
                            $_SESSION['email'] = $user_data->email;
                            $_SESSION['password'] = $user_data->password;
                            
                            header('Location:'.admin);
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
            header('Location:'.admin);
            die();
        }
    }
    
    public function SingOff(){
        $this->auth->SingOff();
    }
  
}