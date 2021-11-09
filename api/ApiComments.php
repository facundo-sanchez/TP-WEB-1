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
        }
    }

    public function sendComments(){
        $this->auth->checkLoggedIn();
        $data = $this->getData();
        $id_news = $data->id_news;
        $comment = $data->comment;
        $points = $data->points;
        $date = date("m.d.y");
       
        $id = $this->model->addComments($comment,$points,$date,$id_news);
        $validate = $this->model->getCommentsId($id);
       
        if($validate){
            $this->view->response($validate,200);
        }else{
            $this->view->response('ERROR SERVER',500);
        }
    }

    public function deleteComments($params = null){
        $this->auth->checkLoggedIn();
        if($validate = $this->auth->checkAdmin()){
            $id = $params[':ID'];
            $comments=$this->model->getCommentsId($id);
            if($comments){
                $this->model->deleteComments($id);
                $validate = $this->model->getCommentsId($id);
                var_dump($validate);
                if($validate == false){
                    $this->view->response('Eliminado');
                }else{
                    $this->view->response('ERROR SERVER',500);   
                }
            }else{
                $this->view->response('Comentario id '.$id.' no encontrado',404);
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
                    $comments = $this->model->orderComments('SELECT * FROM `comments` WHERE id_news = ? ORDER BY date ASC',$id);
                    $this->view->response($comments);
                }elseif($option === 'point'){
                    $comments = $this->model->orderComments('SELECT * FROM `comments` WHERE id_news = ? ORDER BY points ASC',$id);
                    $this->view->response($comments);
                }else{
                    $this->view->response('NOT FOUND',404);
                }

            }elseif($order == 'desc'){
                if($option === 'date'){
                    $comments = $this->model->orderComments('SELECT * FROM `comments` WHERE id_news = ? ORDER BY date DESC',$id);
                    $this->view->response($comments);
                }elseif($option === 'point'){
                    $comments = $this->model->orderComments('SELECT * FROM `comments` WHERE id_news = ? ORDER BY points DESC',$id);
                    $this->view->response($comments);
                }else{
                    $this->view->response('NOT FOUND',404);
                }
               
            }else{
                $this->view->response('NOT FOUND',404);
            }
        }else{
            echo 'no';
        }
    }

    public function filterComments($params = null){
        $id = $params[':ID'];
        $filter = $params[':FILTER'];
        if(isset($filter)){
            if($filter >=1 && $filter<=5){
                $comments = $this->model->filterComments($id,$filter);
                if($comments){
                    $this->view->response($comments);
                }else{
                    $this->view->response('Comments with points not found',404);
                }
            }else{
                $this->view->response('Error point',404);
            }
        }else{
            $this->view->response('Not found',404);
        }
    }

}