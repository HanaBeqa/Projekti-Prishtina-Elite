<?php
include "Auth.php";
$auth = new Auth();

if (isset($_GET['logout'])) {
    $auth->logout();
}

if (isset($_POST['login'])) {
    $remember = isset($_POST['remember']);
    $success = $auth->login($_POST['username'], $_POST['password'], $remember);

    if ($success) {
        if ($auth->role() === "admin") {
            header("Location: main_dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        $error = "Username ose password gabim!";
    }
}

if ($auth->check()) {
    if ($auth->role() === "admin") {
        header("Location: main_dashboard.php");
    } else {
        header("Location: home.php");
    }
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="SignInStyle.css">
</head>
<body>
    <nav class="navbar">
       <div class="logo">
        <img src="llogo.jpg" alt="Prishtina Elite logo">
     </div>
    <p class="shkrim">Sign up to see more about Prishtina Elite !</p>
    </nav>

    <div class="background-overlay">
 <div class="auth-box">

    <div class="switch">
        <button class="active" type="button">Log In</button>
        <button id="signupBtn" type="button">Sign Up</button>
    </div>

    <form method="POST" class="form login">
        

        <div class="emailPassword">
            <label >Username</label>
            <input type="text" id="username" name="username">
            

            <label>Password</label>
            <input type="password" id="password" name="password">
            
        </div>
        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
        </div>
        <br>
        <button class="submit" id="loginBtn" name="login">Log In</button>
        
    </form>

    
</div>
<div class="foto1">
<img  src="IMG_1210.jpeg" alt="Background Image">
</div>

</div>
<script>
    
    document.getElementById("signupBtn").onclick = function () {
        window.location.href = "SignUp.html";
    };

   
    document.querySelector("form").addEventListener("submit", function (event) {

    let username = document.getElementById("username");
    let password = document.getElementById("password");

    let valid = true;

    let usernameRegex = /^[a-zA-Z0-9]{3,15}$/;
    if (!username.value.trim() || !usernameRegex.test(username.value.trim())) {
        username.style.border = "2px solid red";
        username.value = "";
        username.placeholder = "Username must be 3-15 letters or numbers!";
        valid = false;
    } else {
        username.style.border = "2px solid green";
    }

    let passwordRegex = /^.{6,}$/; 
    if (!password.value.trim() || !passwordRegex.test(password.value.trim())) {
        password.style.border = "2px solid red";
        password.value = "";
        password.placeholder = "Password must be at least 6 characters!";
        valid = false;
    } else {
        password.style.border = "2px solid green";
    }

    if (!valid) {
        event.preventDefault(); 
    }


   
});
</script>

</body>
</html>