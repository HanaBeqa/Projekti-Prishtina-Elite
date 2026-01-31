<?php
require_once "../Register.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $register = new Register();
    $register->add(
        $_POST['full_name'],
        $_POST['parent_name'],
        $_POST['age'],
        $_POST['gender'],
        $_POST['school'],
        $_POST['email'],
        $_POST['phone']
    );

    header("Location: ../thankYou.html");
    exit;
}