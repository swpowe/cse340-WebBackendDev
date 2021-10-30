<?php

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';

// Get the array of classifications
$classifications = getClassifications();
// print_r($classifications); //!! Testing ONLY
// Build a navigation bar using the $classifications array
// $dropdownItems = '<option>';
foreach ($classifications as $classification) {
    $dropdownItems .= "<option value='$classification[1]'>$classification[0]</option>";
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
        <h2>*Note all Fields are Required</h2>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <select name="classificationId" id="vehicle-classification" required>
                <option value="" disabled selected>Choose Car Classification</option>
                <?php echo $dropdownItems ?>
                <?php if (isset($classifications)) {
                    echo "selected='$classifications'";
                }  ?>
            </select>
            <label for="vehicle-make">Make</label>
            <input type="text" id="vehicle-make" name="clientMake" required <?php if (isset($clientMake)) {
                                                                                echo "value='$clientMake'";
                                                                            }  ?> />
            <label for="vehicle-model">Model</label>
            <input type="text" id="vehicle-model" name="clientModel" required <?php if (isset($clientModel)) {
                                                                                    echo "value='$clientModel'";
                                                                                }  ?> />
            <label for="vehicle-desc">Description</label>
            <textarea name="clientDescription" id="vehicle-desc" cols="60" rows="5" placeholder="Please enter a vehicle description" required <?php if (isset($clientDescription)) {
                                                                                                                                                    echo "value='$clientDescription'";
                                                                                                                                                }  ?>></textarea>
            <label for="vehicle-image-path">Image Path</label>
            <input type="text" id="vehicle-image-path" name="clientImage" required <?php if (isset($clientImage)) {
                                                                                        echo "value='$clientImage'";
                                                                                    }  ?> />
            <label for="vehicle-thumb-path">Thumbnail Path</label>
            <input type="text" id="vehicle-thumb-path" name="clientThumbnail" required <?php if (isset($clientThumbnail)) {
                                                                                            echo "value='$clientThumbnail'";
                                                                                        }  ?> />
            <label for="vehicle-price">Price</label>
            <input type="number" step="0.01" id="vehicle-price" name="clientPrice" required <?php if (isset($clientPrice)) {
                                                                                                echo "value='$clientPrice'";
                                                                                            }  ?> />
            <label for="vehicle-stock"># In Stock</label>
            <input type="number" id="vehicle-stock" name="clientStock" required <?php if (isset($clientStock)) {
                                                                                    echo "value='$clientStock'";
                                                                                }  ?> />
            <label for="vehicle-color">Color</label>
            <input type="text" id="vehicle-color" name="clientColor" required <?php if (isset($clientColor)) {
                                                                                    echo "value='$clientColor'";
                                                                                }  ?> />

            <input type="submit" value="Add Vehicle" />

            <input type="hidden" name="action" value="add-vehicle" />
        </form>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>