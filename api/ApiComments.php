<?php
require_once('./api/ApiController.php');

class ApiComments extends ApiController{

    public function __construct(){
        parent::__construct();
    }

    public function getCommentsAll(){
        $comments = $this->model->getComments();
        $this->view->response($comments);
    }

    public function getCommentsNewsId($params = null){
        $id = $params[':ID'];
        $comment = $this->model->getCommentsNewsId($id);
        if($comment){
            $this->view->response($comment);
        }else{
            $this->view->response('Comments not found',404);
        }
    }

    public function sendComments(){
        $this->auth->checkLoggedIn();
        $data = $this->getData();
    
        if(isset($data->id_news) && isset($data->comment) && isset($data->points) && filter_var($data->id_news,FILTER_VALIDATE_INT)){
            if(strlen($data->comment)>200 && strlen($data->point)>1){
                $this->view->response('Max Caracter',200);
            }else{
                $id_news = $data->id_news;
                $comment = $data->comment;
                $points = $data->points;
                
                date_default_timezone_set('America/Argentina/Buenos_Aires');    
                $date = date('Y-m-d h:i:s',time());  
                $id_user = $_SESSION['user_id'];

                $id = $this->model->addComments($comment,$points,$date,$id_news,$id_user);
                $validate = $this->model->getCommentsId($id);
               
                if($validate){
                    $this->view->response($validate,200);
                }else{
                    $this->view->response('ERROR SERVER',500);
                }
            }
          
        }else{
            $this->view->response('Incomplete fields',200);
        }
       
    }

    public function deleteComments($params = null){
        $this->auth->checkLoggedIn();

        if($validate = $this->auth->checkAdmin()){
            if(isset($params[':ID']) && filter_var($params[':ID'],FILTER_VALIDATE_INT)){
                $id = $params[':ID'];
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
                    $this->view->response('Comment id '.$id.' not fount',404);
                }
            }else{
                $this->view->response('Incomplete fields',200);
            }
            
        }
    }

    public function orderComments($params = null){
        if(isset($params[':ID']) && isset($params[':ORDER']) && isset($params[':OPTION'])){
            $id = $params[':ID'];
            $order = $params[':ORDER'];
            $option = $params[':OPTION'];
            if($order === 'asc'){
                if($option === 'date'){
                  
                    $comments = $this->model->orderComments('SELECT a.id,a.comment,a.points,a.date,a.id_news,a.id_users,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_news = ? AND a.id_users = b.id ORDER BY date ASC',$id);
                    $this->view->response($comments);
                }elseif($option === 'point'){
                    $comments = $this->model->orderComments('SELECT a.id,a.comment,a.points,a.date,a.id_news,a.id_users,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_news = ? AND a.id_users = b.id ORDER BY points ASC',$id);
                    $this->view->response($comments);
                }else{
                    $this->view->response('Option not found',404);
                }
            }elseif($order == 'desc'){
                if($option === 'date'){
                    $comments = $this->model->orderComments('SELECT a.id,a.comment,a.points,a.date,a.id_news,a.id_users,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_news = ? AND a.id_users = b.id ORDER BY date DESC',$id);
                    $this->view->response($comments);
                }elseif($option === 'point'){
                    $comments = $this->model->orderComments('SELECT a.id,a.comment,a.points,a.date,a.id_news,a.id_users,b.name,b.surname,b.role FROM comments a LEFT JOIN users b ON a.id_news = ? AND a.id_users = b.id ORDER BY points DESC',$id);
                    $this->view->response($comments);
                }else{
                    $this->view->response('Option not found',404);
                }
            }else{
                $this->view->response('Order not found',404);
            }
        }else{
            $this->view->response('Invalid order or option',200);
        }
    }

    public function filterComments($params = null){
        $id = $params[':ID'];
        $filter = $params[':FILTER'];
        if(isset($filter) && filter_var($filter,FILTER_VALIDATE_INT)){
            if($filter >=1 && $filter<=5){
                $comments = $this->model->filterComments($id,$filter);
                if($comments){
                    $this->view->response($comments);
                }
            }else{
                $this->view->response('Error point',404);
            }
        }else{
            $this->view->response('Invalid filtering',200);
        }
    }

}