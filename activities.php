<?php
include_once "Activity.php";
$activityObj = new Activity();
$activities = $activityObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="activitiesStyle.css">
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
    
    <section class="titulli">
        <h1><a href="ContactUs.html">JOIN US FOR MORE EXCITING ADVENTURES!</a></h1>
        
    </section>


    <?php foreach($activities as $key => $a): 
        $images = explode(',', $a['images']); 
        $firstImage = $images[0] ?? '';
    ?>
        <section class="activitie1">
            <div class="image-activitie1">
                <button onclick="Ndrysho(<?= $key ?>, -1)">&lt</button>
                <img src="<?= $firstImage ?>" alt="activity" id="fotot<?= $key ?>">
                <button onclick="Ndrysho(<?= $key ?>, 1)">&gt</button>
            </div>
            <div class="text-activitie1">
                <h2><?= htmlspecialchars($a['title']) ?></h2>
                <p><?= htmlspecialchars($a['description']) ?></p>
            </div>
        </section>
    <?php endforeach; ?>



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

         <script>
        
        let imagesArr = [];
        <?php foreach($activities as $k => $a): ?>
            imagesArr[<?= $k ?>] = <?= json_encode(explode(',', $a['images'])) ?>;
        <?php endforeach; ?>

        let indexes = Array(imagesArr.length).fill(0);

        function Ndrysho(activityKey, step){
            indexes[activityKey] += step;
            if(indexes[activityKey] < 0) indexes[activityKey] = imagesArr[activityKey].length - 1;
            if(indexes[activityKey] >= imagesArr[activityKey].length) indexes[activityKey] = 0;
            document.getElementById('fotot'+activityKey).src = imagesArr[activityKey][indexes[activityKey]];
        }
    </script>

</body>
</html>