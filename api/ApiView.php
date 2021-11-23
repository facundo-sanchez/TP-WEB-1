<?php

class ApiView{
    public function response($data,$code = 200){
        header('Content-Type: application/json');
        header('HTTP/1.1 '.$code. ' '.$this->requestStatus($code));
        echo json_encode($data);
    }
    private function requestStatus($code){
        $status = array(
            200 =>'OK',
            204 =>'No Content',
            404 =>'Not Found',
            500 => 'Server Error'
        );
        return (isset($status[$code]))? $status[$code]: $status[500];
    }
}