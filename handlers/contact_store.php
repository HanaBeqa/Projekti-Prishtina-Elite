<?php
require_once "../Contact.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $contact = new Contact();
    $contact->add(
        $_POST['full_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['subject'],
        $_POST['message']
    );

    header("Location: ../thankYou.html");
    exit;
}