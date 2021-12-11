<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Home</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen"> <!-- ?<?php echo date('l jS \of F Y h:i:s A'); ?> -->
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen"> <!-- ?<?php echo date('l jS \of F Y h:i:s A'); ?> -->

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="template document">
</head>
<body>
    <div id="wrapper">

<!-- Header -->
<header>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php' ?>
</header>

<!-- Nav Bar -->
<nav>
<?php echo $navList; ?> <!-- This should go to index.php and display the navBar from that variable -->
</nav>
<!-- Main Content -->
<main>
    <h1 id="welcome-text">Welcome to PHP Motors!</h1>
    <div class="messageDiv">
    <?php if(isset($_SESSION["message"])) {
             echo $_SESSION["message"];
             unset($_SESSION["message"]);
    } ?>
    </div>
    <div id="deloran-div">
        <div id="delorean-div-txt">
        <h2>DMC Delorean</h2>
        <h3>3 Cup holders</h3>
        <h3>Superman doors</h3>
        <h3>Fuzzy Dice!</h3>
    </div> <!-- end of delorean-txt-div -->
        <img src="/phpmotors/images/vehicles/delorean.jpg" alt="deloran" id="delorean-img">
        <div id="own-button-div-small">
            <button id="own-button-small" onclick="#">Own Today</button>
        </div> 
</div> <!-- end of delorean-div -->
<div id="bottom-section">
    <div id="reviews-div">
        <h2>DMC Delorean Reviews</h2>
        <ul>
            <li>"So fast its almost like traveling in time." (4/5)</li>
            <li>"Coolest ride on the road." (4/5)</li>
            <li>"I'm feeling Marty McFly!" (5/5)</li>
            <li>"The most futuristic ride of our day." (4.5/5)</li>
            <li>"80's livin and I love it!" (5/5)</li>
        </ul>
    </div> <!-- end of reviews div -->
    <div id="upgrades-div-full">
    <h2 id="upgrades-title">DMC Delorean Upgrades</h2>
    <div id="upgrades-div">
        <div class="box-container"><div class="box box1"><div><img src="/phpmotors/images/upgrades/flux-cap.png" alt="flux-cap"></div></div><a class="upgrade-links" href="#">Flux Capacitor</a></div>
        <div class="box-container"><div class="box box2"><div><img src="/phpmotors/images/upgrades/flame.jpg" alt="flame"></div></div><a  class="upgrade-links" href="#">Flame Decals</a></div>
        <div class="box-container"><div class="box box3"><div><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper_sticker"></div></div><a class="upgrade-links" href="#">Bumper Stickers</a></div>
        <div class="box-container"><div class="box box4"><div><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="hub-cap"></div></div><a class="upgrade-links" href="#">Hub Caps</a></div>
    </div> <!-- end of upgrades div -->
    </div> <!-- end of upgrades-div-full --> 
</div> <!-- end of bottom-section --> 
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>