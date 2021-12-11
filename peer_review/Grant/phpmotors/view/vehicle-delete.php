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
    <title><?php if (isset($invInfo['invMake'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
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
        <h1><?php if (isset($invInfo['invMake'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
            } ?></h1>
        <h3>Confirm Vehicle Deletion. The delete is permanent.</h3>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <fieldset>
                <label for="classificationId">Car Classification</label><br>
                <select name="classificationId" id="classificationId">
                    <?php echo $classifList; ?>
                </select><br>
                <label for="invMake">Make</label><br>
                <input name="invMake" id="invMake" type="text" <?php if (isset($invMake)) {
                                                                    echo "value='$invMake'";
                                                                } elseif (isset($invInfo['invMake'])) {
                                                                    echo "value='$invInfo[invMake]'";
                                                                } ?> readonly><br>
                <label for="invModel">Model</label><br>
                <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                        echo "value='$invModel'";
                                                                    } elseif (isset($invInfo['invModel'])) {
                                                                        echo "value='$invInfo[invModel]'";
                                                                    } ?> readonly><br>
                <label for="invDescription">Description</label><br>
                <textarea name="invDescription" id="invDescription" readonly><?php if (isset($invDescription)) {
                                                                                    echo $invDescription;
                                                                                } elseif (isset($invInfo['invDescription'])) {
                                                                                    echo $invInfo['invDescription'];
                                                                                } ?></textarea><br>
                <input type="submit" name="submit" id="add-btn" value="Delete Vehicle">
                <input type="hidden" name="action" value="deleteVehicle">
                <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                                echo $invInfo['invId'];
                                                            } elseif (isset($invId)) {
                                                                echo $invId;
                                                            } ?>
                                                            ">
            </fieldset>
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