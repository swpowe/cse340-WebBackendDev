<?php
// Make sure the user is logged in AND is an Admin; redirect to home if not
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 3) {
    header('Location: /phpmotors');
}

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';

// Get the array of classifications
$classifications = getClassifications();
// print_r($classifications); //!! Testing ONLY

foreach ($classifications as $classification) {
    if ($classification[1] == $invId) { //?? If passed invId then mark as selected
        $dropdownItems .= "<option value='$classification[1]' selected>$classification[0]</option>";
    }
    $dropdownItems .= "<option value='$classification[1]'>$classification[0]</option>";

    // print_r($invInfo); //!! TESTING ONLY
}

// Build the classifications option list //?? His code I didn't use. wk9 en7
// $classifList = '<select name="classificationId" id="classificationId">';
// $classifList .= "<option>Choose a Car Classification</option>";
// foreach ($carClassifications as $classification) {
//  $classifList .= "<option value='$classification[classificationId]'";
//  if(isset($classificationId)){
//   if($classification['classificationId'] === $classificationId){
//    $classifList .= ' selected ';
//   }
//  } elseif(isset($invInfo['classificationId'])){
//  if($classification['classificationId'] === $invInfo['classificationId']){
//   $classifList .= ' selected ';
//  }
// }
// $classifList .= ">$classification[classificationName]</option>";
// }
// $classifList .= '</select>';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";
            } ?> | PHP Motors</title>
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
        <h2><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify$invMake $invModel";
            } ?></h2>
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
            </select>
            <label for="vehicle-make">Make</label>
            <input type="text" id="vehicle-make" name="invMake" required <?php if (isset($invMake)) { //!! need ot change all client and inv make model?
                                                                                echo "value='$invMake'";
                                                                            } elseif (isset($invInfo['invModel'])) {
                                                                                echo "value='$invInfo[invModel]'";
                                                                            } ?> />
            <label for="vehicle-model">Model</label>
            <input type="text" id="vehicle-model" name="invModel" required <?php if (isset($invModel)) {
                                                                                    echo "value='$invModel'";
                                                                                } elseif (isset($invInfo['invMake'])) {
                                                                                    echo "value='$invInfo[invMake]'";
                                                                                } ?> />
            <label for="vehicle-desc">Description</label>
            <textarea name="invDescription" id="vehicle-desc" cols="60" rows="5" placeholder="Please enter a vehicle description" required> <?php if (isset($invDescription)) {
                                                                                                                                                    echo $invDescription;
                                                                                                                                                } elseif (isset($invInfo['invDescription'])) {
                                                                                                                                                    echo $invInfo['invDescription'];
                                                                                                                                                }  ?></textarea>
            <label for="vehicle-image-path">Image Path</label>
            <input type="text" id="vehicle-image-path" name="invImage" required <?php if (isset($invImage)) {
                                                                                        echo "value='$invImage'";
                                                                                    } elseif (isset($invInfo['invImage'])) {
                                                                                        echo "value='$invInfo[invImage]'";
                                                                                    }  ?> />
            <label for="vehicle-thumb-path">Thumbnail Path</label>
            <input type="text" id="vehicle-thumb-path" name="invThumbnail" required <?php if (isset($invThumbnail)) {
                                                                                            echo "value='$invThumbnail'";
                                                                                        } elseif (isset($invInfo['invThumbnail'])) {
                                                                                            echo "value='$invInfo[invThumbnail]'";
                                                                                        }  ?> />
            <label for="vehicle-price">Price</label>
            <input type="number" step="0.01" id="vehicle-price" name="invPrice" required <?php if (isset($invPrice)) {
                                                                                                echo "value='$invPrice'";
                                                                                            } elseif (isset($invInfo['invPrice'])) {
                                                                                                echo "value='$invInfo[invPrice]'";
                                                                                            }  ?> />
            <label for="vehicle-stock"># In Stock</label>
            <input type="number" id="vehicle-stock" name="invStock" required <?php if (isset($invStock)) {
                                                                                    echo "value='$invStock'";
                                                                                } elseif (isset($invInfo['invStock'])) {
                                                                                    echo "value='$invInfo[invStock]'";
                                                                                }  ?> />
            <label for="vehicle-color">Color</label>
            <input type="text" id="vehicle-color" name="invColor" required <?php if (isset($invColor)) {
                                                                                    echo "value='$invColor'";
                                                                                } elseif (isset($invInfo['invColor'])) {
                                                                                    echo "value='$invInfo[invColor]'";
                                                                                }  ?> />

            <input type="submit" name="submit" value="Update Vehicle" />

            <input type="hidden" name="action" value="updateVehicle" />
            <input type="hidden" name="invId" value="
                <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
                elseif(isset($invId)){ echo $invId; } ?>
            ">
        </form>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>