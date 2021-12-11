<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/classification.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/alt-views.css" type="text/css" rel="stylesheet" media="screen">
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
<!-- < ?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/nav.php' ?>  NOTE: remove space before the '?' to restore php functionality -->
<?php echo $navList; ?> <!-- This should go to index.php and display the navBar from that variable -->
</nav>
<!-- Main Content -->
<main>
    <!-- Display message if one exists -->
    <h1 id="classificationTitle"><?php echo $classificationName; ?> vehicles</h1>
    <?php if(isset($message)){
    echo $message; }
    ?>
    <!-- Display vehicle list if one exists -->
    <?php if(isset($vehicleDisplay)){
    echo $vehicleDisplay;
    } ?>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>