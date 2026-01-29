<?php
include "Auth.php";
$auth = new Auth();


if(!$auth->isAdmin()){
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Dashboard</title>
    <link rel="stylesheet" href="main_dashboard_style.css">

</head>
<body>
<h2>Main Dashboard - Admin</h2>
<p>Mirë se erdhe, <?= $auth->user(); ?>!</p>

<ul>
    <li><a href="register_dashboard.php">Registers</a></li>
    <li><a href="merch_dashboard.php">Merch Orders</a></li>
    <li><a href="tickets_dashboard.php">Tickets Orders</a></li>
    <li><a href="contact_dashboard.php">Contact Messages</a></li>
</ul>

<a href="login.php?logout=true">Logout</a>
</body>
</html>
