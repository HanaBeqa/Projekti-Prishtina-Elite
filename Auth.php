<?php

 include "Database.php";

class Auth {
    

    public function __construct() {
        session_start();
        $this->db = new Database();

        
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

            $this->saveLogin($username, "admin");
            return true; 
        }

       
        if(!empty($username) && !empty($password)){
        $_SESSION['user'] = $username;
        $_SESSION['role'] = "user";

        if($remember){
            setcookie("remember_user", $username, time()+86400, "/");
            setcookie("remember_role", "user", time()+86400, "/");
        }

        $this->saveLogin($username, "user");
        return true;
    }

    return false;
}

private function saveLogin($username, $role){
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO logins (username, role, login_time) VALUES (:username, :role, NOW())");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
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
        header("Location: index.php");
        exit;
    }

    public function isAdmin(){
        return $this->check() && $_SESSION['role'] == 'admin';
    }
}
?>
