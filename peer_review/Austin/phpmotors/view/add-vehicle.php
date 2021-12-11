<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Add A Vehicle</title>
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
    <h1 id="addVehicleTitle">Add Vehicle</h1>
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
                        <?php if(isset($invMake)){echo "value='$invMake'";}  
                        ?> required>
                    </label>
                </div><br>
                <div class="form-box">
                    <label for="model">Model
                        <input type="text" id="model" name="invModel" 
                        <?php if(isset($invModel)){echo "value='$invModel'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="description">Description
                        <textarea id="description" name="invDescription" required><?php if(isset($invDescription)){echo "$invDescription";}?></textarea>
                    </label>
                </div>
                <div class="form-box">
                    <label for="image">Image Path
                        <input type="text" id="image" name="invImage" 
                        <?php if(isset($invImage)){echo "value='$invImage'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="thumbnail">Thumbnail Path
                        <input type="text" id="thumbnail" name="invThumbnail" 
                        <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="price">Price
                        <input type="number" step="0.01" min="0" id="price" name="invPrice" 
                        <?php if(isset($invPrice)){echo "value='$invPrice'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="stock">Stock
                        <input type="number" id="stock" name="invStock" min="1" 
                        <?php if(isset($invStock)){echo "value='$invStock'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="color">Color
                        <input type="text" id="color" name="invColor" 
                        <?php if(isset($invColor)){echo "value='$invColor'";}  
                        ?> required>
                    </label>
                </div>
<input type="submit" name="submit" id="addVehicleBtn" value="Add Vehicle">
<input type="hidden" name="action" value="addVehicle">
</form>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>