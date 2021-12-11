<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Title element has php block to change the title based upon the vehicle information that's currently selected -->
<title>PHP Motors | <?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?></title>
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
    <!-- Main H1 element has php code block to display vehicle info for selected vehicle -->
    <h1 id="addVehicleTitle"><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Delete $invMake $invModel"; }?></h1>
    <p id="addVehicleWarning">Confirm Vehicle Deletion. The delete is permanent.</p>
    <!-- Display errors sent from vehicles controller -->
    <div class="messageDiv">
    <?php
if (isset($message)) {
 echo $message;
}
?>
</div>
        <form name="addVehicleForm" action="/phpmotors/vehicles/index.php" method="post">
                <div class="form-box">
                    <label for="make">Make
                        <input type="text" id="make" name="invMake" readonly
                        <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
                    </label>
                </div><br>
                <div class="form-box">
                    <label for="model">Model
                        <input type="text" id="model" name="invModel" readonly
                        <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
                    </label>
                </div>
                <div class="form-box">
                    <label for="description">Description
                        <textarea id="description" name="invDescription" readonly ><?php if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                    </label>
                </div>
<input type="submit" name="submit" id="modVehicleBtn" value="Delete Vehicle">
<input type="hidden" name="action" value="deleteVehicle">
<input type="hidden" name="invId" value="
<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?>">
</form>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>