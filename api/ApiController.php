<?php
require_once('./api/ApiView.php');
require_once('./model/CommentsModel.php');
require_once('./helper/AuthHelper.php');
abstract class ApiController{
    private $data;
    protected $model;
    protected $view;
    protected $auth;

    public function __construct(){
        $this->data = file_get_contents('php://input');
        $this->view = new ApiView();
        $this->model = new CommentsModel();
        $this->auth = new AuthHelper();
    }

    protected function getData(){
        return json_decode($this->data);
    }
}