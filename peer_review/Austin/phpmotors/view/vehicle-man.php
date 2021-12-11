<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Vehicle Management</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen">
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
    <h1 id="vehicleManagementTitle">Vehicle Management</h1>
    <ul id="vehicleManagementList">
        <li><a href="http://localhost/phpmotors/vehicles/index.php?action=add-classification" title="Enter Car Classifications Menu" id="carClassificationsMenu">Add Classification</a></li>
        <li><a href="http://localhost/phpmotors/vehicles/index.php?action=add-vehicle" title="Enter Add Vehicle Menu" id="addVehicleMenu">Add Vehicle</a></li>
    </ul>
<!-- Not able to style by wrapping with "messageDiv" class like other '$message's because of 'h2' and 'p' elements in second if statement below -->
    <?php
if (isset($message)) { 
 echo $message; 
} 
if (isset($classificationList)) { 
 echo '<h2 id="seeInventoryTitle">Vehicles By Classification</h2>'; 
 echo '<p id="seeInventoryText">Choose a classification to see those vehicles</p>'; 
 echo $classificationList; 
}
?>
<!-- Tell user that JS is required if browser detects that it is disabled. If enabled, this shouldn't appear at all -->
<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>

<!-- Injection from inventory.js with table contents will occur below -->
<table id="inventoryDisplay"></table>

</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
<script src="../js/inventory.js"></script>
</div> <!-- End of Wrapper -->
</body>
</html>
<?php unset($_SESSION['message']); ?>