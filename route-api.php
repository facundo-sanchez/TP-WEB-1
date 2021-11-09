<?php
require_once('./lib/Router.php');
require_once('./api/ApiComments.php');

//definir header
define('BASE_URL','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/home');
define('admin','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/admin/');
define('login','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/login');
//crear router
$router = new Router();

//tabla de ruteo
$router->addRoute('comments','POST','ApiComments','sendComments');
$router->addRoute('comments','GET','ApiComments','getCommentsAll');
$router->addRoute('comments/:ID','GET','ApiComments','getCommentsNewsId');
$router->addRoute('comments/:ID','DELETE','ApiComments','deleteComments');
$router->addRoute('comments/order/:ID/:ORDER/:OPTION','GET','ApiComments','orderComments');
$router->addRoute('comments/filter/:ID/:FILTER','GET','ApiComments','filterComments');

//rutear
$resource = $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router->route($resource,$method);