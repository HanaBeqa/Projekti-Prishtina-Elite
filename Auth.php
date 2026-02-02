<?php
require_once "Database.php";

class Auth {
    private $conn;

    public function __construct(){
        session_start();

        $db = new Database();
        $this->conn = $db->getConnection();

       
        if(!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])){
            $_SESSION['user'] = $_COOKIE['remember_user'];
            $_SESSION['role'] = $_COOKIE['remember_role'];
        }
    }

    public function login($username, $password, $remember = false){

        
        if($username === "admin" && $password === "123456"){
            $_SESSION['user'] = "admin";
            $_SESSION['role'] = "admin";

            if($remember){
                setcookie("remember_user","admin",time()+86400,"/");
                setcookie("remember_role","admin",time()+86400,"/");
            }
            return true;
        }

      
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username'=>$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = "user";

            if($remember){
                setcookie("remember_user",$user['username'],time()+86400,"/");
                setcookie("remember_role","user",time()+86400,"/");
            }
            return true;
        }

        return false;
    }

    
    public function register($username, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (:u, :p)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'u' => $username,
            'p' => $hash
        ]);
    }

    public function check(){
        return isset($_SESSION['user']);
    }

    public function role(){
        return $_SESSION['role'] ?? null;
    }

    public function logout(){
        session_destroy();
        setcookie("remember_user","",time()-3600,"/");
        setcookie("remember_role","",time()-3600,"/");
        header("Location: index.php");
        exit;
    }
}
