<?php
require_once('controller/NewsController.php');

session_start();

//urls
define('BASE_URL','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/home');
define('admin','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/admin');

$controller = new NewsController();


$sesion = $controller->VerifySession();
$controller->showHeader($sesion);

if(!empty($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = 'home';
}

$params = explode('/',$action);

switch($params[0]){
    case 'home':
        if(empty($params[1])){
            $controller->showHome();
        }else{
            header('Location:'.BASE_URL);
        }
        break;
        
    case 'news':
        $controller->showNews($params[1]);
        break;

    /*
    case 'category':
        $controller->showCategory();
        break;
    */

    case 'filter':
        $controller->showFilter($params[1]);
        break;

    case 'login':
        //parametros del user y password

        //esto va en la funcion de login
       
        $_SESSION['login'] = true;
        $_SESSION['user'] = 'facundo11';

        $controller->showGetLogin();
        var_dump($_SESSION);
        break;

    case 'confirm-login':
        $controller->Login();
        break;

    case 'admin':
        $controller->showAdminNews($sesion);
        
        break;

    //news
    case 'send-news':
        $controller->showSendNews($sesion);
        break;

    case 'confirm-update-news':
        $controller->showConfirmUpdateNews($sesion,$params[1]);
        break;

    case 'update-news':
        $sesion = $controller->VerifySession();
        if($sesion === true){
            $controller->showUpdateNews($sesion);
        }else{
            header('Location:'.BASE_URL);
        }
       
        break;

    case 'confirm-delete-news':
        $controller->showConfirmDeleteNews($sesion,$params[1]);
        break;

    case 'delete-news':
        $controller->showDeleteNews($sesion,$params[1]);
        break;
  
    //category
    case 'send-category':
        $controller->showSendCategory($sesion);
        break;

    case 'confirm-update-category':
        $controller->showConfirmUpdateCategory($sesion,$params[1]);
        break;
        
    case 'update-category':
        $controller->showUpdateCategory($sesion);
        break;

    case 'confirm-delete-category':
        $controller->showConfirmDeleteCategory($sesion,$params[1]);
        break;

    case 'delete-category':
        $controller->showDeleteCategory($sesion,$params[1]);
        break;
    case 'sing-off':
        $controller->showSingOff();
        break;

    default:
        $controller->showNotFound('ERROR 404','Page not found');
        die();
        break;
        
}