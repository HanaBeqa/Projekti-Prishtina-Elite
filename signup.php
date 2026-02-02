<?php
require_once "Auth.php";
$auth = new Auth();

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($auth->register($username, $password)){
        header("Location: index.php"); 
        exit;
    } else {
        echo "Username ekziston!";
    }
}
