<?php
require_once('controller/NewsController.php');
require_once('controller/CategoryController.php');
require_once('controller/UserController.php');

session_start();

//urls
define('BASE_URL','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/home');
define('admin','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/admin');

$controller_news = new NewsController();
$controller_category = new CategoryController();
$controller_user = new UserController();

$sesion = $controller_user->VerifySession();

$controller_category->showHeader($sesion,$controller_category->showCategory());

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
        $controller_news->showNews($params[1]);
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
            $controller_news->showNotFound('ERROR 404','Category not found');
        }
        break;

    case 'register-user':
        //animacion para el registro
        $controller_user->showGetRegister($sesion);
        break;

    case 'register':
        $controller_user->Register();
        break;

    case 'login':
        $controller_user->showGetLogin($sesion);
        break;

    case 'confirm-login':
        $controller_user->Login();
        break;

    case 'admin':
        if($sesion === true){
            $category = $controller_category->showCategory();
            $admin = $controller_user->ShowUser();
            $controller_news->showAdminNews($category,$admin);
        }else{
            header('Location:'.BASE_URL);
        }
        break;

    //news
    case 'send-news':
        $controller_news->showSendNews($sesion);
        break;

    case 'confirm-update-news':
        if(isset($params[1])){
            $category = $controller_category->showCategory();
            $controller_news->showConfirmUpdateNews($sesion,$category,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
      
        break;

    case 'update-news':
        $controller_news->showUpdateNews($sesion);
        break;

    case 'confirm-delete-news':
        if(isset($params[1])){
            $controller_news->showConfirmDeleteNews($sesion,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
        
        break;

    case 'delete-news':
        if(isset($params[1])){
            $controller_news->showDeleteNews($sesion,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
      
        break;
  
    //category
    case 'send-category':
        $controller_category->showSendCategory($sesion);
        break;

    case 'confirm-update-category':
        if(isset($params[1])){
            $controller_category->showConfirmUpdateCategory($sesion,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
      
        break;
        
    case 'update-category':
        $controller_category->showUpdateCategory($sesion);
        break;

    case 'confirm-delete-category':
        if(isset($params[1])){
            $controller_category->showConfirmDeleteCategory($sesion,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
      
        break;

    case 'delete-category':
        if(isset($params[1])){
            $controller_category->showDeleteCategory($sesion,$params[1]);
        }else{
            header('Location:'.BASE_URL);
        }
       
        break;

    case 'sing-off':
        $controller_user->ShowSingOff();
        break;

    default:
        $controller_news->showNotFound('ERROR 404','Page not found');
        die();
        break;
        
}