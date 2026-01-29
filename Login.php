<?php
include "Auth.php";
$auth = new Auth();


if(isset($_GET['logout'])){
    $auth->logout();
}


if(isset($_POST['login'])){
    $remember = isset($_POST['remember']);
    $success = $auth->login($_POST['username'], $_POST['password'], $remember);

    if($success){
        
        if($auth->role() == "admin")
            header("Location: main_dashboard.php");
        else
            header("Location: home.php");
        exit;
    } else {
        $error = "Username ose password gabim!";
    }
}


if($auth->check()){
    if($auth->role() == "admin") header("Location: main_dashboard.php");
    else header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="checkbox" name="remember"> Remember Me<br><br>
    <button name="login">Login</button>
</form>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
