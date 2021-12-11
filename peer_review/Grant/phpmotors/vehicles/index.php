<?php
//this is the vehicles controller

session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';

$navList = navList();

//for adding vehicles to the database
$invMake = filter_input(INPUT_POST, 'invMake');
$invModel = filter_input(INPUT_POST, 'invModel');
$invDescription = filter_input(INPUT_POST, 'invDescription');
$invImage = filter_input(INPUT_POST, 'invImage');
$invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
$invPrice = filter_input(INPUT_POST, 'invPrice');
$invStock = filter_input(INPUT_POST, 'invStock');
$invColor = filter_input(INPUT_POST, 'invColor');
// for adding classifications to database
$classificationName = filter_input(INPUT_POST, 'classificationName');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'addVehicle':
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_STRING));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/add-vehicle.php';
            exit;
        }

        $vehicleAdd = addVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);

        if ($vehicleAdd === 1) {
            $message = "<p>$invMake $invModel has been successfully added to the list.</p>";
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/add-vehicle.php';
            exit;
        } else {
            $message = "<p>No vehicle was added. Check form fields and try again.</p>";
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/add-vehicle.php';
            exit;
        }
        break;

    case 'addClassification':
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING));

        if (empty($classificationName)) {
            $message = '<p>Please provide a classification name.</p>';
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/add-classification.php';
            exit;
        }

        $classificationAdd = addClassification($classificationName);

        if ($classificationAdd === 1) {
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/add-classification.php';
            exit;
        }
        break;

    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_STRING));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/vehicle-update.php';
            exit;
        }

        $updateResult = updateVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $invId);

        if ($updateResult) {
            $message = "<p class='notify'>$invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Update failed. Check form fields and try again.</p>";
            include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/vehicle-update.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);

        if ($deleteResult) {
            $message = "<p class='notice'>Item was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
            deleted.$deleteResult $invId</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'detail':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $vehicle = getVehiclesById($invId);
        $reviews = getReviewsByItem($invId);
        if (!count($vehicle)) {
            $message = "<p class='notice'>Sorry, no vehicle could be found.</p>";
        } else {
            $vehicleDetail = buildVehiclesDetail($vehicle);
            // print_r($vehicle);
        }
        if (!$reviews) {
            $reviewMessage = '<p>There are no reviews for this item.</p>';
        } else {
            $reviewList = buildReviews($reviews);
            // print_r($reviews);
        }

        include '../view/vehicle-detail.php';
        break;

    default:
        $classifications = getClassifications();
        $classificationList = buildClassificationList($classifications);

        include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/vehicle-main.php';
}
