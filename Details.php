<?php
include_once "LastMatchPhoto.php";
include_once "Poster.php";

$photoObj = new LastMatchPhoto();
$photos = $photoObj->getAll();

$posterObj = new Poster();  
$posters = $posterObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="DetailsStyle.css">
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

<section class="roster">
    <h1>ROSTER</h1>
    <div class="senior-junior">
    <div class="rosteri">
        <img src="IMG_0809.jpeg" alt="senioret">
    </div>
    <div class="rosteri">
        <img src="IMG_0810.jpeg" alt="junioret">
    </div>
    </div>
    </section>

    <section class="match-photos">
    <h1>LAST MATCH — PHOTOS</h1>

    <div class="gallery">
    <?php foreach($photos as $row) { ?>
        <div class="photo">
            <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Last match photo">
        </div>
    <?php } ?>
</div>

</section>

    <section class="posters">
    <h1>RECENT POSTERS</h1>
    <div class="posters-container">
        <?php foreach($posters as $p): ?>
            <div class="posteri">
                <img src="<?= htmlspecialchars($p['image_path']) ?>" alt="poster">
            </div>
        <?php endforeach; ?>
    </div>
</section>


<section class="vlerat">
    <h1>OUR VALUES</h1>
<div class="values">
  <div class="value">
    <div class="icon">🤝</div>
    <h4>Teamwork</h4>
    <p>Every player contributes and collaborates for the success of the team.</p>
  </div>

  <div class="value">
    <div class="icon">⏱️</div>
    <h4>Discipline</h4>
    <p>We respect rules and training schedules for constant improvement.</p>
  </div>

  <div class="value">
    <div class="icon">⚖️</div>
    <h4>Fair Play</h4>
    <p>We play honestly and respect opponents and referees.</p>
  </div>

  <div class="value">
    <div class="icon">🔥</div>
    <h4>Determination</h4>
    <p>We are committed to achieving the season's goals.</p>
  </div>

  <div class="value">
    <div class="icon">❤️</div>
    <h4>Passion</h4>
    <p>We play with energy and joy, keeping motivation high.</p>
  </div>
</div>

</section>

<section class="trajnimet">
    <h1>WEEKLY TRAINING SCHEDULE</h1>
<ul class="training-list">
  <li class="training-day day1">
    <h4>Monday</h4>
    <p>Jumping drills and agility exercises.</p>
  </li>
  <li class="training-day day2">
    <h4>Tuesday</h4>
    <p>Serving practice and accuracy training.</p>
  </li>
  <li class="training-day day3">
    <h4>Wednesday</h4>
    <p>Muscle strengthening and conditioning.</p>
  </li>
  <li class="training-day day4">
    <h4>Thursday</h4>
    <p>Team strategy and set plays practice.</p>
  </li>
  <li class="training-day day5">
    <h4>Friday</h4>
    <p>Scrimmage games and cool-down exercises.</p>
  </li>
</ul>

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