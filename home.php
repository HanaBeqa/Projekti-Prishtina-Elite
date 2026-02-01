<?php
include_once "Standing.php";

$standingsObj = new Standing();
$allStandings = $standingsObj->getAll();

include_once "Video.php";
$videoObj = new Video();
$allVideos = $videoObj->getAll();

include_once "Matches.php";
$matchObj = new Matches();
$allMatches = $matchObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prishtina Elite</title>
     <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
       <div class="logo">
        <img src="llogo.jpg" alt="Prishtina Elite logo">
     </div>
     <ul class="list">
        <li><a href="home.php">Home</a></li>
        <li><a href="aboutsUs.php">About Us</a></li>
        <li><a href="ContactUs.html">Contact us</a></li>
        <li><a href="Details.php">Details</a></li>
        <li><a href="activities.php">Activities</a></li>
        <li class="logout"><a href="index.php?logout=1">Log Out</a></li>
        
     </ul>
    </nav>
<header class="banner">
    <img src="IMG_6776.jpeg" alt="banner">
    <div class="textbanner">
    <h1>Welcome to Prishtina Elite!</h1>
    <p>Join us for an exciting season</p>
    </div>
    </header>
    <br>
   
    <section class="Schedule">
   <h1>Results 2025:</h1>
    <div class="row">
        <?php foreach($allMatches as $m): ?>
        <div class="rezults">
            <img src="<?= htmlspecialchars($m['image_path']) ?>" alt="<?= htmlspecialchars($m['team_opponent']) ?>">
            <p>Prishtina Elite vs <?= htmlspecialchars($m['team_opponent']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    </section>

         <section class="tabela-champ">
            <div id="tab">
            <h2>Team Standings</h2>
            <table class="tabela">
                <tr>
                    <th>Ranking</th>
                    <th>Team</th>
                    <th>Points</th>
                    <th colspan="3">Matches</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Palyed</th>
                    <th>Won</th>
                    <th>Lost</th>
                </tr>
                <?php $rank = 1; foreach($allStandings as $s): ?>
            <tr>
                <td><?= $rank++ ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= $s['points'] ?></td>
                <td><?= $s['played'] ?></td>
                <td><?= $s['won'] ?></td>
                <td><?= $s['lost'] ?></td>
            </tr>
            <?php endforeach; ?>
            </table>
            </div>
            <div class="leaders">
                <h2>Leading the Championship</h2>
                <img src="IMG_0527.jpeg" alt="leaders">
            </div>        
         </section>

           <section class="videos-text">
            <h2>Game videos</h2>
             <div class="video-container">
            <div id="video1">
                <iframe src="https://www.youtube.com/embed/gBIJJAMID60?si=98nhecwaGKIxQ0QS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <p>Finalja: Prishtina Elite vs Feronikeli!</p>
            </div>
            <div class="other-videos">
             <?php foreach($allVideos as $v): ?>
             <div class="next-video">
             <?= $v['iframe'] ?>
            <div class="video-desc">
                <p><?= date("F j, Y", strtotime($v['date_created'])) ?></p>
                <p><?= htmlspecialchars($v['description']) ?></p>
             </div>
             </div>
          <?php endforeach; ?>
            </div>
            </div>
        </section>



         <footer class="footer">
            <section class="sponsors">
                <img src="sponsors3.png">
                <img src="sponsor2.png">
            </section>
            <section class="footer-row-2">
                <div class="footer-text">
            <div class="logo-f">
              <img src="llogo.jpg" alt="Prishtina Elite logo">
             </div>
        <p>&copy; 2025 Prishtina Elite. All rights reserved.</p>
        </div>
        <div class="footer-list">
            <ul>
                <li>Email: kvprishtinaelite@gmail.com</li>
                <li>Phone number: 049-551-777</li>
                <li>Location:(Prishtina, Kosovo) Shkolla "Emin Duraku"</li>
            </ul>
        </div>
        </section>
         </footer>
</body>
</html>
