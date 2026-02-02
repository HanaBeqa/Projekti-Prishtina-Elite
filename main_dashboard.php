<?php
include "Auth.php";
$auth = new Auth();

if(!$auth->isAdmin()){
    header("Location: home.php");
    exit;
}

$registrations = 124;
$merchOrders   = 56;
$ticketOrders  = 89;
$messages      = 23;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Dashboard - Admin</title>
    <link rel="stylesheet" href="mainDashboardStyle.css">
</head>
<body>

<div class="dashboard-container">

   
    <header class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Mirë se erdhe, <strong><?= $auth->user(); ?></strong></p>
        <a class="logout-btn" href="login.php?logout=true">Logout</a>
    </header>

    
    <section class="stats">
        <div class="stat-card">
            <h3>Registrime</h3>
            <p><?= $registrations ?></p>
        </div>

        <div class="stat-card">
            <h3>Merch Orders</h3>
            <p><?= $merchOrders ?></p>
        </div>

        <div class="stat-card">
            <h3>Ticket Orders</h3>
            <p><?= $ticketOrders ?></p>
        </div>

        <div class="stat-card">
            <h3>Mesazhe</h3>
            <p><?= $messages ?></p>
        </div>
    </section>

   
    <section class="management">
        <a href="register_dashboard.php" class="manage-card">
            <h3>Registers</h3>
            <p>Menaxho regjistrimet e përdoruesve</p>
        </a>

        <a href="merch_dashboard.php" class="manage-card">
            <h3>Merch Orders</h3>
            <p>Shiko dhe përditëso porositë</p>
        </a>

        <a href="tickets_dashboard.php" class="manage-card">
            <h3>Tickets</h3>
            <p>Menaxho biletat e shitura</p>
        </a>

        <a href="contact_dashboard.php" class="manage-card">
            <h3>Contact</h3>
            <p>Lexo mesazhet e ardhura</p>
        </a>

        <a href="standings_dashboard.php" class="manage-card">
        <h3>Standings</h3>
        <p>Menaxho tabelën e kampionatit</p>
        </a>

        
        <a href="players_dashboard.php" class="manage-card">
        <h3>Player List</h3>
        <p>Menaxho listën e lojtareve</p>
        </a>


        <a href="lastmatch_dashboard.php" class="manage-card">
        <h3>Last Match Photos</h3>
        <p>Menaxho fotot e fundit të lojës</p>
        </a>

        <a href="posters_dashboard.php" class="manage-card">
        <h3>Posters</h3>
        <p>Menaxho posterat e fundit</p>
        </a>

        <a href="videos_dashboard.php" class="manage-card">
        <h3>Videos</h3>
        <p>Menaxho videot e fundit</p>
        </a>

        <a href="matches_dashboard.php" class="manage-card">
        <h3>Matches</h3>
        <p>Menaxho rezultatet e lojës</p>
        </a>

        <a href="activities_dashboard.php" class="manage-card">
        <h3>Activities</h3>
        <p>Menaxho aktivitetet e fundit</p>
        </a>



    </section>

</div>

</body>
</html>

