<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT']. '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
// $dropdownItems = '<option>';
foreach ($classifications as $classification) {
 $dropdownItems .= "<option>$classification[0]</option>";
}
// $dropdownItems .= '</option>';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Add a new vehicle.</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css">

</head>


<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/header.php'
    ?>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h2>Add Vehicle</h2>
        <h3>*Note all Fields are Required</h3>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <select name="vehicle-classification" id="vehicle-classification">
                Choose Classification
                <option value="" disabled selected>Choose Car Classification</option>
                <!-- for each -->
                <option>test</option>
                <option>test 2</option>
                <?php echo $dropdownItems ?>
            </select>
            <label for="vehicle-make">Make</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />
            <label for="vehicle-make">Model</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />
            <label for="vehicle-make">Description</label>
            <textarea name="vehicle-desc" id="vehicle-desc" cols="60" rows="5" placeholder="Please enter a vehicle description"></textarea>
            <label for="vehicle-make">Image Path</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />
            <label for="vehicle-make">Price</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />
            <label for="vehicle-make"># In Stock</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />
            <label for="vehicle-make">Color</label>
            <input type="text" id="vehicle-make" name="vehicle-make" />

            <input type="submit" value="Add Vehicle" />

            <input type="hidden" name="action" value="add-vehicle" />
        </form>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>