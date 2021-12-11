<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Home - Grant Petersen</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
</head>

<body>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php';echo $header; ?>
    </header>

    <nav>
    <?php echo navList(); ?>
    </nav>

    <main>
        <div class="wrapper">
            <h1>Welcome to PHP Motors!</h1>
            <div id="adtext">
                <h2>DMC Delorean</h2>
                <p>3 Cup holders <br>Superman doors <br>Fuzzy dice!</p>
                <a><button>Own Today</button></a>
            </div>
            <img src="/phpmotors/images/delorean.jpg" alt="delorean car">
            <div class="upgrades">
                <h3>Delorean Upgrades</h3>
                <div class="upgradeTabs">
                    <div class="upgradebox" id="upgrade1"><img src="/phpmotors/images/upgrades/flux-cap.png" alt="flux capacitor"><a href="#">Flux Capacitor</a></div>
                    <div class="upgradebox" id="upgrade2"><img src="/phpmotors/images/upgrades/flame.jpg" alt="flame"><a href="#">Flame Decals</a></div>
                    <div class="upgradebox" id="upgrade3"><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="bumper sticker"><a href="#">Bumper Stickers</a></div>
                    <div class="upgradebox" id="upgrade4"><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="hub cap"><a href="#">Hub Caps</a></div>
                </div>
            </div>
            <div class="reviews">
                <h3>DMC Delorean Reviews</h3>
                <ul>
                    <li>"So fast its almost like traveling in time." (4/5)</li>
                    <li>"Coolest ride on the road." (4/5)</li>
                    <li>"I'm feeling Marty McFly! (5/5)</li>
                    <li>"The most futuristic ride of our day." (4.5/5)</li>
                    <li>"80's livin and I love it!" (5/5)</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. </br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.</br>
            Last Updated: </p>
    </footer>
</body>

</html>