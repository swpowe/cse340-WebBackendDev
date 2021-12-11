<?php
require_once '../library/connections.php';
require_once '../model/main-model.php';
$classifications = getClassifications();
$classifList = "<option value='' disabled selected>Choose Car Classification</option>";

foreach ($classifications as $classification) {
    $classifList .= "<option value='$classification[1]'";
    if (isset($classificationId)) {
        if ($classification[1] === $classificationId) {
            $classifList .= ' selected ';
        }
    } elseif (isset($invInfo['classificationId'])) {
        if ($classification['classificationId'] === $invInfo['classificationId']) {
            $classifList .= ' selected ';
        }
    }

    $classifList .= ">$classification[0]</option>";
}

if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
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
    <link rel="stylesheet" href="/phpmotors/css/small.css">
</head>

<body>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
        echo $header; ?>
    </header>

    <nav>
    <?php echo navList(); ?>
    </nav>

    <main>
        <h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify$invMake $invModel";
            } ?></h1>
        <h3>*All Fields Are Required</h3>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <label for="classificationId">Car Classification</label><br>
            <select name="classificationId" id="classificationId">
                <?php echo $classifList; ?>
            </select><br>
            <label for="invMake">Make</label><br>
            <input name="invMake" id="invMake" type="text" <?php if (isset($invMake)) {
                                                                echo "value='$invMake'";
                                                            } elseif (isset($invInfo['invMake'])) {
                                                                echo "value='$invInfo[invMake]'";
                                                            } ?> required><br>
            <label for="invModel">Model</label><br>
            <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                    echo "value='$invModel'";
                                                                } elseif (isset($invInfo['invModel'])) {
                                                                    echo "value='$invInfo[invModel]'";
                                                                } ?> required><br>
            <label for="invDescription">Description</label><br>
            <textarea name="invDescription" id="invDescription" required><?php if (isset($invDescription)) {
                                                                                echo $invDescription;
                                                                            } elseif (isset($invInfo['invDescription'])) {
                                                                                echo $invInfo['invDescription'];
                                                                            } ?></textarea><br>
            <label for="invImage">Image Path</label><br>
            <input type="text" name="invImage" id="invImage" <?php if (isset($invImage)) {
                                                                    echo "value='$invImage'";
                                                                } elseif (isset($invInfo['invImage'])) {
                                                                    echo "value='$invInfo[invImage]'";
                                                                } ?> required><br>
            <label for="invThumbnail">Thumbnail Path</label><br>
            <input type="text" name="invThumbnail" id="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                            echo "value='$invThumbnail'";
                                                                        } elseif (isset($invInfo['invThumbnail'])) {
                                                                            echo "value='$invInfo[invThumbnail]'";
                                                                        } ?> required><br>
            <label for="invPrice">Price</label><br>
            <input type="number" name="invPrice" id="invPrice" <?php if (isset($invPrice)) {
                                                                    echo "value='$invPrice'";
                                                                } elseif (isset($invInfo['invPrice'])) {
                                                                    echo "value='$invInfo[invPrice]'";
                                                                } ?> required><br>
            <label for="invStock"># In Stock</label><br>
            <input type="number" name="invStock" id="invStock" <?php if (isset($invStock)) {
                                                                    echo "value='$invStock'";
                                                                } elseif (isset($invInfo['invStock'])) {
                                                                    echo "value='$invInfo[invStock]'";
                                                                } ?> required><br>
            <label for="invColor">Color</label><br>
            <input type="text" name="invColor" id="invColor" <?php if (isset($invColor)) {
                                                                    echo "value='$invColor'";
                                                                } elseif (isset($invInfo['invColor'])) {
                                                                    echo "value='$invInfo[invColor]'";
                                                                } ?> required><br>
            <input type="submit" name="submit" id="add-btn" value="Update Vehicle">
            <input type="hidden" name="action" value="updateVehicle">
            <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                            echo $invInfo['invId'];
                                                        } elseif (isset($invId)) {
                                                            echo $invId;
                                                        } ?>
">
        </form>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>
</body>

</html>