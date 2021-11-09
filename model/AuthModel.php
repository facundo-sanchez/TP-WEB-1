<?php

require_once('SQLModel.php');

class AuthModel extends SQLModel{

    function __construct(){
       parent::__construct();
    }

    function getUsers($id){

        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE id != ?');
            $query->execute([$id]);
            $users = $query->fetchAll(PDO::FETCH_OBJ);

            return $users;
        }catch(Exception $e){
           echo 'ERROR: '.$e->getMessage();
        }
    }

    function getUsersId($id){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE id = ?');
            $query->execute([$id]);
            $users = $query->fetch(PDO::FETCH_OBJ);

            return $users;
        }catch(Exception $e){
           echo 'ERROR: '.$e->getMessage();
        }
    }
    
    function SingUp($name,$surname,$email,$password){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            if($result === false){
                $query = $this->connect->prepare('INSERT INTO users (name,surname,email,password) VALUES (?,?,?,?)');
                $query->execute([$name,$surname,$email,$password]);
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            echo 'ERROR:'.$e->getMessage();
        }
        
    }

    function UserLogin($email){
        try{
            $query = $this->connect->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$email]);
            $user = $query->fetch(PDO::FETCH_OBJ);
            return $user;
        }catch(Exception $e){
            echo 'ERROR '.$e->getMessage();
        }
    }

    function userAdmin($id){
        try{
            $query = $this->connect->prepare('UPDATE users SET role = 1 WHERE id = ?');
            $query->execute([$id]);
        }catch(Exception $e){
            echo 'ERROR: '.$e->getMessage();
        }
    }

    function userDeleteAdmin($id){
        try{
            $query = $this->connect->prepare('UPDATE users SET role = 0 WHERE id = ? ');
            $query->execute([$id]);
        }catch(Exception $e){
            echo 'ERROR: '.$e->getMessage();
        }
    }
    
    function userDelete($id){
        try{
            $query = $this->connect->prepare('DELETE FROM users WHERE id = ?');
            $query->execute([$id]);
            
        }catch(Exception $e){
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}