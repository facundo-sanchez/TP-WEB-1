<?php
require_once('./api/ApiController.php');

class ApiComments extends ApiController{

    public function __construct(){
        parent::__construct();
    }

    public function getCommentsAll(){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
        $comments = $this->model->getComments();
        $this->view->response($comments);
    }

    public function getCommentsNewsId($params = null){
        $id = filter_var($params[':ID'],FILTER_SANITIZE_NUMBER_INT);
        if(!empty($_GET['points']) || !empty($_GET['order'])){
            if(!empty($_GET['order'])){
                $this->orderComments($id,$_GET['order']);
            }elseif(!empty($_GET['points'])){
                $this->filterComments($id,$_GET['points']);
            }
        }else{
            $comment = $this->model->getCommentsNewsId($id);

            if($comment){
                $this->view->response($comment);
            }else{
                $this->view->response('Comments not found',204);
            }
        }
       
    }

    public function sendComments(){
        $this->auth->checkLoggedIn();
        $data = $this->getData();
    
        if(isset($data->id_news) && isset($data->comment) && isset($data->points)){
            if(strlen($data->comment)>200 || strlen($data->points)>1){
                $this->view->response('Max Caracter',204);
            }else{
                if($data->points >=1 && $data->points <=5 && $data->comment != ''){
                    $id_news = filter_var($data->id_news,FILTER_SANITIZE_NUMBER_INT);
                    $comment = filter_var($data->comment,FILTER_SANITIZE_STRING);
                    $points = filter_var($data->points,FILTER_SANITIZE_NUMBER_INT);
                    
                    date_default_timezone_set('America/Argentina/Buenos_Aires');    
                    $date = date('Y-m-d H:i:s',time());  
                    $id_user = $_SESSION['user_id'];
    
                    $id = $this->model->addComments($comment,$points,$date,$id_news,$id_user);
                    $validate = $this->model->getCommentsId($id);
                   
                    if($validate){
                        $this->view->response($validate,200);
                    }else{
                        $this->view->response('ERROR SERVER',500);
                    }
                }else{
                    $this->view->response('ERROR Points or Comment',200);
                }
               
            }
        }else{
            $this->view->response('Incomplete fields',204);
        }
       
    }

    public function deleteComments($params = null){
        $this->auth->checkLoggedIn();
        $this->auth->checkAdmin();
          
        if(isset($params[':ID']) && $params[':ID'] != ''){
            $id = filter_var($params[':ID'],FILTER_SANITIZE_NUMBER_INT);
            $comments=$this->model->getCommentsId($id);
            if($comments){
                $this->model->deleteComments($id);
                $validate = $this->model->getCommentsId($id);
                if($validate == false){
                    $this->view->response('Eliminado');
                }else{
                    $this->view->response('ERROR SERVER',500);   
                }
            }else{
                $this->view->response('Comment id '.$id.' not fount',204);
            }
        }else{
            $this->view->response('Incomplete fields',204);
        }
    }

    public function deleteCommentsIdUser($id){
        $delete = $this->model->deleteCommentsIdUser($id);
        return $delete;
    }

    public function deleteCommentsIdNews($id){
        $delete = $this->model->deleteCommentsIdNews($id);
        return $delete;
    }
    
    public function orderComments($id,$order){
        $order = filter_var($order,FILTER_SANITIZE_URL);
        $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
        if($order === 'asc-date'){
            $comments = $this->model->orderComments('asc-date',$id);
            $this->view->response($comments);
        }elseif($order === 'des-date'){
            $comments = $this->model->orderComments('des-date',$id);
            $this->view->response($comments);
        }elseif($order === 'asc-point'){
            $comments = $this->model->orderComments('asc-point',$id);
            $this->view->response($comments);
        }elseif($order === 'des-point'){
            $comments = $this->model->orderComments('des-point',$id);
            $this->view->response($comments);
        }
    }

    public function filterComments($id){
        $filter = filter_var($_GET['points'],FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

        if(isset($filter) && filter_var($filter,FILTER_VALIDATE_INT)){
            if($filter >=1 && $filter<=5){
                $comments = $this->model->filterComments($id,$filter);
                if($comments){
                    $this->view->response($comments,200);
                }else{
                    $this->view->response('Comments not found',204);
                }
            }else{
                $this->view->response('Points not found',204);
            }
        }else{
            $this->view->response('Filter not found',200);
        }
    }

}