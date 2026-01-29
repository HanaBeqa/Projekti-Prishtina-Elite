<?php
class Auth {
    public function __construct() {
        session_start();

        
        if(!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])){
            $_SESSION['user'] = $_COOKIE['remember_user'];
            $_SESSION['role'] = $_COOKIE['remember_role'];
        }
    }

    
    public function login($username, $password, $remember=false){
       
        if($username == "admin" && $password == "123456"){
            $_SESSION['user'] = $username;
            $_SESSION['role'] = "admin";

            if($remember){
                setcookie("remember_user", $username, time()+86400, "/");
                setcookie("remember_role", "admin", time()+86400, "/");
            }

            return true; 
        }

       
        if($username == "user" && $password == "123"){
            $_SESSION['user'] = $username;
            $_SESSION['role'] = "user";

            if($remember){
                setcookie("remember_user", $username, time()+86400, "/");
                setcookie("remember_role", "user", time()+86400, "/");
            }

            return true; 
        }

        return false; 
    }

    public function check(){
        return isset($_SESSION['user']);
    }

    public function user(){
        return $_SESSION['user'] ?? null;
    }

    public function role(){
        return $_SESSION['role'] ?? null;
    }

    public function logout(){
        session_destroy();
        setcookie("remember_user", "", time()-3600, "/");
        setcookie("remember_role", "", time()-3600, "/");
        header("Location: login.php");
        exit;
    }

    public function isAdmin(){
        return $this->check() && $_SESSION['role'] == 'admin';
    }
}
?>
