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


$controller_category->showHeader($controller_user->VerifySession(),$controller_category->showCategory());

if(!empty($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = 'home';
}

$params = explode('/',$action);

switch($params[0]){
    case 'home':
        if(empty($params[1])){
            $controller_news->showHome();
        }else{
            header('Location:'.BASE_URL);
        }
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
        $controller_news->showFilter($params[1]);
        break;

    case 'login':
        //parametros del user y password

        //esto va en la funcion de login
        
        $_SESSION['login'] = true;
        $_SESSION['user'] = 'facundo11';

        $controller_user->showGetLogin();
        var_dump($_SESSION);
        break;

    case 'confirm-login':
        $controller_user->Login();
        break;

    case 'admin':
        $category = $controller_category->showCategory();
        $controller_news->showAdminNews($controller_user->VerifySession(),$category);
        
        break;

    //news
    case 'send-news':
        $controller_news->showSendNews($sesion);
        break;

    case 'confirm-update-news':
        $controller_news->showConfirmUpdateNews($sesion,$params[1]);
        break;

    case 'update-news':
        $sesion = $controller->VerifySession();
        if($sesion === true){
            $controller_news->showUpdateNews($sesion);
        }else{
            header('Location:'.BASE_URL);
        }
       
        break;

    case 'confirm-delete-news':
        $controller_news->showConfirmDeleteNews($sesion,$params[1]);
        break;

    case 'delete-news':
        $controller_news->showDeleteNews($sesion,$params[1]);
        break;
  
    //category
    case 'send-category':
        $controller_category->showSendCategory($sesion);
        break;

    case 'confirm-update-category':
        $controller_category->showConfirmUpdateCategory($sesion,$params[1]);
        break;
        
    case 'update-category':
        $controller_category->showUpdateCategory($sesion);
        break;

    case 'confirm-delete-category':
        $controller_category->showConfirmDeleteCategory($sesion,$params[1]);
        break;

    case 'delete-category':
        $controller_category->showDeleteCategory($sesion,$params[1]);
        break;

    case 'sing-off':
        $controller_user->ShowSingOff();
        break;

    default:
        $controller_news->showNotFound('ERROR 404','Page not found');
        die();
        break;
        
}