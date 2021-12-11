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
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?></title>
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
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?></h1>
    <p id="addVehicleWarning">*Note all Fields are Required*</p>
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
        <?php echo $classificationList; ?> <!-- This pulls available classifications from vehicles controller file, which has the dropdown menu stored in a single varible -->
                </div><br>
                <div class="form-box">
                    <label for="make">Make
                        <input type="text" id="make" name="invMake" 
                        <?php if(isset($invMake)){ echo "value='$invMake'"; } 
                        elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> required>
                    </label>
                </div><br>
                <div class="form-box">
                    <label for="model">Model
                        <input type="text" id="model" name="invModel" 
                        <?php if(isset($invModel)){ echo "value='$invModel'"; } 
                        elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="description">Description
                        <textarea id="description" name="invDescription" required><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                    </label>
                </div>
                <div class="form-box">
                    <label for="image">Image Path
                        <input type="text" id="image" name="invImage" 
                        <?php if(isset($invImage)){ echo "value='$invImage'"; } 
                        elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="thumbnail">Thumbnail Path
                        <input type="text" id="thumbnail" name="invThumbnail" 
                        <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'"; } 
                        elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="price">Price
                        <input type="number" step="0.01" min="0" id="price" name="invPrice" 
                        <?php if(isset($invPrice)){ echo "value='$invPrice'"; } 
                        elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="stock">Stock
                        <input type="number" id="stock" name="invStock" min="1" 
                        <?php if(isset($invStock)){ echo "value='$invStock'"; } 
                        elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="color">Color
                        <input type="text" id="color" name="invColor" 
                        <?php if(isset($invColor)){ echo "value='$invColor'"; } 
                        elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?> required>
                    </label>
                </div>
<input type="submit" name="submit" id="modVehicleBtn" value="Update Vehicle">
<input type="hidden" name="action" value="updateVehicle">
<input type="hidden" name="invId" value="
<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
elseif(isset($invId)){ echo $invId; } ?>
">
</form>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>