<?php
// This is the Vehicle Controller

// Create or Access a Session
session_start();

//!! Get the database connection file
require_once '../library/connections.php';

// Get the Functions library
require_once '../library/functions.php';
//!! Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
//!! Getting the accounts model
require_once '../model/vehicles-model.php';
//!! Get the array of classifications
$classifications = getClassifications();

// var_dump($classifications); // Testing Only. Returns DB object data
// 	exit;

// //!! Build a navigation bar using the $classifications array
// $navList = '<ul>';
// $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//     $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
// }
// $navList .= '</ul>';

$navList = dynamicNav($classifications);

//!! echo $navList; // Testing Only
// exit;

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'add-vehicle-page':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        break;
    case 'add-classification-page':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
        break;
    case 'add-vehicle':
        $clientMake = trim(filter_input(INPUT_POST, 'clientMake', FILTER_SANITIZE_STRING));
        $clientModel = trim(filter_input(INPUT_POST, 'clientModel', FILTER_SANITIZE_STRING));
        $clientDescription = trim(filter_input(INPUT_POST, 'clientDescription', FILTER_SANITIZE_STRING));
        $clientImage = trim(filter_input(INPUT_POST, 'clientImage', FILTER_SANITIZE_STRING));
        $clientThumbnail = trim(filter_input(INPUT_POST, 'clientThumbnail', FILTER_SANITIZE_STRING));
        $clientPrice = trim(filter_input(INPUT_POST, 'clientPrice'));
        $clientPrice = trim(filter_var($clientPrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $clientPrice = trim(filter_var($clientPrice, FILTER_VALIDATE_FLOAT));
        $clientStock = trim(filter_input(INPUT_POST, 'clientStock', FILTER_SANITIZE_NUMBER_INT));
        $clientColor = trim(filter_input(INPUT_POST, 'clientColor', FILTER_SANITIZE_STRING));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId'));

        // echo "<h1>clientPrice: $clientPrice </h1>"; //!! Testing ONLY

        if (empty($clientMake) || empty($clientModel) || empty($clientDescription) || empty($clientImage) || empty($clientThumbnail) || empty($clientPrice) || empty($clientStock) || empty($clientColor) || empty($classificationId)) {
            $message = "<h2 class=\"status-error\"> Please complete all empty form fields. </h2>";
            include '../view/add-vehicle.php';
            exit;
        }

        $addOutcome = addVehicle($clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId);

        // echo "<h2> returned value : $addOutcome</h2>"; //!! Testing ONLY

        if ($addOutcome === 1) {
            $message = "<h2 class=\"status-good\">New vehicle $clientMake:$clientModel added to the inventory. </h2>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<h2 class=\"status-error\">There was a problem adding $clientMake:$clientModel to the inventory. Please try again. </h2>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;
    case 'add-classification':

        $clientClassification = trim(filter_input(INPUT_POST, 'clientClassification', FILTER_SANITIZE_STRING));

        // Check for missing data
        if (empty($clientClassification)) {
            $message = "<h2 class=\"status-error\">Please provide a new classification.</h2>";
            include '../view/add-classification.php';
            exit;
        }

        $newClassification = addClassification($clientClassification);

        if ($newClassification === 1) {
            // $message = "<h2 class=\"status-good\">New Classification $clientClassification added. </h2>";
            // include '../view/add-classification.php';
            // !! changed to refresh page and include new classification in nav
            header('Location: /phpmotors/vehicles/?action=add-classification-page');
            exit;
        } else {
            $message = "<h2 class=\"status-error\">Sorry there was an error add $clientClassification. Please try again.</h2>";
            include '../view/add-classification.php';
            exit;
        }

        break;
    case 'register':
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
        $clientLastname = filter_input(INPUT_POST, 'clientLastname');
        $clientEmail = filter_input(INPUT_POST, 'clientEmail');
        $clientPassword = filter_input(INPUT_POST, 'clientPassword');

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            include '../view/login.php';
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        //TODO refresh the nav bar
        //TODO turn parts of this into functions to be called rather then repeat code
        break;

        /* * ********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    * ********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

        // used to modify vehicle info
    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);

        echo 'Passed invID: ' . $invId; //!! Testing ONLY
        print_r($invInfo); //!! Testing ONLY

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/update-vehicle.php';
        exit;
        break;
    case 'updateVehicle':
        //!! seems empty
        echo $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        echo $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        echo $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        echo $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        echo $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        echo $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        echo $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        echo $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        echo $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        echo $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please complete all information for the updated item! Double check the classification of the item.</p>';
            include '../view/update-vehicle.php';
            exit;
        }
        $updateResult = updateVehicle($invId, $classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);
        if ($updateResult) {
            $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Error. The vehicle was not updated.</p>";
            include '../view/update-vehicle.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/delete-vehicle.php';
        exit;
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
            deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    default:
        $classificationList = buildClassificationList($classifications); // event trigger watching select change
        include '../view/vehicle-man.php';
        exit;
        break;
}
