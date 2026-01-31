<?php
require_once "../Merch.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $merch = new Merch();
    $merch->add(
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['jersey_type'],
        $_POST['size']
    );

    header("Location: ../thankYou.html");
    exit;
}
