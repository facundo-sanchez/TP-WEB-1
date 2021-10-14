<?php
require_once('controller/NewsController.php');
require_once('controller/CategoryController.php');
require_once('controller/AuthController.php');

//urls
define('BASE_URL','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/home');
define('admin','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/admin');
define('login','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/login');

$controller_news = new NewsController();
$controller_category = new CategoryController();
$controller_user = new AuthController();

$controller_category->showHeader();

if(!empty($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = 'home';
}

$params = explode('/',$action);

switch($params[0]){
    case 'home':
        $controller_news->showHome();
        break;
        
    case 'news':
        if(isset($params[1])){
            $controller_news->showNews($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
      
        break;
        
    /*
    case 'category':
        $controller->showCategory();
        break;
    */

    case 'filter':
        if(isset($params[1])){
            $controller_news->showFilter($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
      
        break;

    case 'register':
        $controller_user->Register();
        break;

    case 'login':
        $controller_user->Login();
        break;

    case 'admin':
        $controller_user->checkLogged();
        $category = $controller_category->showCategory();
        $admin = $controller_user->ShowUser();
        $controller_news->showAdminNews($category,$admin);
   
        break;

    //news
    case 'send-news':
        $controller_news->showSendNews();
        break;

    case 'update-news':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $controller_news->showUpdateNews();
        }else{
            if(isset($params[1])){
                $category = $controller_category->showCategory();
                $controller_news->showConfirmUpdateNews($category,$params[1]);
            }else{
                header('Location:'.BASE_URL);
                die();
            }
        }
        break;

    case 'confirm-delete-news':
        if(isset($params[1])){
            $controller_news->showConfirmDeleteNews($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
        break;

    case 'delete-news':
        if(isset($params[1])){
            $controller_news->showDeleteNews($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
        break;
  
    //category
    case 'send-category':
        $controller_category->showSendCategory();
        break;
    
    case 'update-category':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $controller_category->showUpdateCategory();
        }else{
            if(isset($params[1])){
                $controller_category->showConfirmUpdateCategory($params[1]);
            }else{
                header('Location:'.BASE_URL);
                die();
            }
        }
        break;

    case 'confirm-delete-category':
        if(isset($params[1])){
            $controller_category->showConfirmDeleteCategory($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
        break;

    case 'delete-category':
        if(isset($params[1])){
            $controller_category->showDeleteCategory($params[1]);
        }else{
            header('Location:'.BASE_URL);
            die();
        }
       
        break;

    case 'sing-off':
        $controller_user->SingOff();
        break;

    default:
        $controller_news->showNotFound('ERROR 404','Page not found');
        die();
        break;
        
}