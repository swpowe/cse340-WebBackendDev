<?php
// This is the Vehicle Controller

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
        $clientMake = filter_input(INPUT_POST, 'clientMake');
        $clientModel = filter_input(INPUT_POST, 'clientModel');
        $clientDescription = filter_input(INPUT_POST, 'clientDescription');
        $clientImage = filter_input(INPUT_POST, 'clientImage');
        $clientThumbnail = filter_input(INPUT_POST, 'clientThumbnail');
        $clientPrice = filter_input(INPUT_POST, 'clientPrice');
        $clientPrice = filter_var($clientPrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $clientPrice = filter_var($clientPrice, FILTER_VALIDATE_FLOAT);
        $clientStock = filter_input(INPUT_POST, 'clientStock');
        $clientColor = filter_input(INPUT_POST, 'clientColor');
        $classificationId = filter_input(INPUT_POST, 'classificationId');

        // echo "<h1>clientPrice: $clientPrice </h1>"; //!! Testing ONLY

        if(empty($clientMake) || empty($clientModel) || empty($clientDescription) || empty($clientImage) || empty($clientThumbnail) || empty($clientPrice) || empty($clientStock) || empty($clientColor) || empty($classificationId)) {
            $message = "<h2 class=\"status-error\"> Please complete all empty form fields. </h2>";
            include '../view/add-vehicle.php';
            exit;
        }

        $addOutcome = addVehicle($clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId);

        // echo "<h2> returned value : $addOutcome</h2>"; //!! Testing ONLY

        if($addOutcome === 1) {
            $message = "<h2 class=\"status-good\">New vehicle $clientMake:$clientModel added to the inventory. </h2>";
            include '../view/add-vehicle.php';
            exit;
        }else {
            $message = "<h2 class=\"status-error\">There was a problem adding $clientMake:$clientModel to the inventory. Please try again. </h2>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;
    case 'add-classification':

        $clientClassification = filter_input(INPUT_POST, 'clientClassification');

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
    default:
        include '../view/vehicle-man.php';
}
