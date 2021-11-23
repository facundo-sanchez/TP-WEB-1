<?php 
require_once('./api/ApiComments.php');
class CommentsHelper{
    private $comments;

    public function __construct(){
        $this->comments = new ApiComments();
    }

    public function deleteCommentsIdUser($id){
        $delete = $this->comments->deleteCommentsIdUser($id);
        return $delete;
    }
    public function deleteCommentsIdNews($id){
        $delete = $this->comments->deleteCommentsIdNews($id);
        return $delete;
    }

}