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
                    $email = $_POST['user_email'];
                    $password = password_hash($_POST['user_pass'],PASSWORD_BCRYPT);
                    $repeat_password = $_POST['user_repeat_pass'];
    
                    if(password_verify($repeat_password,$password)){
                        $validate = $this->model->SingUp($name,$surname,$email,$password);
                      
                        if($validate === false){
                            $this->view->renderRegister(true);
                        }else if($validate === true){
                            $this->view->renderRegister(false);
                        }
                    }else{
                        $this->view->renderRegister(true);
                    }
                   
                }else{
                    header('Location:'.BASE_URL);
                    die();
                } 
            }else{
                $this->view->renderRegister(null);
            }
        }else{
            header('Location:'.admin);
            die();
        }
        
       
    }

    public function Login(){
        if($this->auth->VerifySession() === false){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!empty($_POST)){
                    $email = $_POST['user_email'];
                    $password = $_POST['user_pass'];
            
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
                        $this->view->renderLogin(true);  
                    }
                }else{
                    header('Location:'.BASE_URL);
                    die();
                }
            }else{
                $this->view->renderLogin(null);
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