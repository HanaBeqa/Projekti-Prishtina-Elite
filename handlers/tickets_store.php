<?php
require_once "../Tickets.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tickets = new Tickets();
    $tickets->add(
        $_POST['full_name'],
        $_POST['team'],
        $_POST['quantity'],
        $_POST['seat_type']
    );

    header("Location: ../thankYou.html");
    exit;
}