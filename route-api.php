<?php
require_once('./lib/Router.php');
require_once('./api/ApiComments.php');

define('BASE_URL','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/home');
define('admin','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/admin/');
define('login','//'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF']).'/login');

$router = new Router();

$router->addRoute('news/comments/','GET','ApiComments','getCommentsAll');
$router->addRoute('news/comments/:ID','GET','ApiComments','getCommentsNewsId');
$router->addRoute('news/comments/','POST','ApiComments','sendComments');
$router->addRoute('news/comments/:ID','DELETE','ApiComments','deleteComments');

$resource = $_GET['resource'];
$method = $_SERVER['REQUEST_METHOD'];
$router->route($resource,$method);