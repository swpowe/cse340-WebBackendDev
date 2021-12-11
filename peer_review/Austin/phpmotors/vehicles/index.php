<?php
/********************************
 * Controller for Vehicles file
 *******************************/

// create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model in order to use associated functions for SQL functionality
require_once '../model/vehicles-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions file
require_once '../library/functions.php';


// Call getClassification function from 'main-model' and assign value to variable
$classifications = getClassifications();

// Build a navigation bar using the buildNavbar function
$navList = buildNavbar($classifications);

//Build classifications list variable for our dropdown menu
$classificationList = '<label for="classificationId">'; //select = dropdown list
$classificationList .= "<select id='classificationId' name='classificationId' required>";
$classificationList .= "<option value='' selected disabled>Choose a Classification</option>"; //Ghost line at top of dropdown

foreach ($classifications as $classification) {
  $classificationList .= "<option value='$classification[classificationId]'";
  if(isset($classificationId)){
   if($classification['classificationId'] === $classificationId){
    $classificationList .= ' selected ';
   }
  } elseif(isset($invInfo['classificationId'])){
    if($classification['classificationId'] === $invInfo['classificationId']){
     $classificationList .= ' selected ';
    }
   }
              // foreach ($classifications as $classification) {
              // $classificationList .= "<option value ='$classification[classificationId]'>$classification[classificationName]</option>";
              // }
$classificationList .= ">$classification[classificationName]</option>";
              }
$classificationList .= '</select>';
$classificationList .= '</label>';


// Logic for traffic direction
$action = filter_input(INPUT_GET, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_POST, 'action');
 }

 switch ($action){
  case 'vehicle-man':
  include '../view/vehicle-man.php';
  break;

  case 'add-classification': // This is FROM 'vehicle management' view TO the 'add classification' view
    include '../view/add-classification.php';
    break;

  case 'addClassification': // This is logic for pressing the 'Add Classification' button 

      // Filter and store the data
      $classificationName = filter_input(INPUT_POST, 'classificationName');

      // Check for missing data
    if(empty($classificationName)){
      $message = '<p>Please enter a classification name.</p>';
      include '../view/add-classification.php';
      exit; 
    }

      // Send the data to the model
      $addClassOutcome = addClassification($classificationName);

      // Check and report the result
    if($addClassOutcome === 1){
      header("refresh: 3; url = http://localhost/phpmotors/vehicles/index.php?action=add-classification"); // This code refreshes the page if the add was successful.
      exit;
    } else { // If registration failed, or addClassOutcome != 1
      $message = "<p>Sorry, your class, '$classificationName', was not added successfully.</p>";
      include '../view/add-classification.php';
      exit;
    }
      break;

  case 'add-vehicle':
    include '../view/add-vehicle.php'; // This is FROM 'vehicle management' view TO the 'add classification' view
    break;

  case 'addVehicle': // This is logic for pressing the hidden 'Add Vehicle' button in its respective view

    // Filter and store the data
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)); // I think 'float' and 'fraction' allow is correct here
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
    $classificationId = trim(filter_input(INPUT_POST, 'classificationId'));

    // Check for missing data
    if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock)
    || empty($invColor) || empty($classificationId)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/add-vehicle.php';
      exit; 
    }

    // Send the data to the model
    $addVehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

    // Check and report the result
    if($addVehicleOutcome === 1){
      $message = "<p>Your vehicle '$invMake $invModel', was successfully added.</p>";
      include '../view/add-vehicle.php';
      exit;
    } else { // If registration failed, or addVehicleOutcome != 1
      $message = "<p>Sorry, your vehicle '$invMake $invModel', was not successfully added.</p>";
      include '../view/add-vehicle.php';
      exit;
    }
      break;

  case 'mod': // This is the modify button on the vehicle management page (injected from inventory.js into the table) 
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
      $message = 'Sorry, no vehicle information could be found.';
     }
    include '../view/vehicle-update.php';

    break;

  case 'getInventoryItems': 
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId); 
    // Convert the array to a JSON object and send it back 
    echo json_encode($inventoryArray);
    break;

    // Update vehicle case statement
  case 'updateVehicle':

      // Filter and store the data
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
      $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
      $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
      $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
      $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
      $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
      $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)); // I think 'float' and 'fraction' allow is correct here
      $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
      $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
      $classificationId = trim(filter_input(INPUT_POST, 'classificationId'));

      // Check for missing data
      if(empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock)
      || empty($invColor) || empty($classificationId)){
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/vehicle-update.php';
      exit; 
      }

      // Send the data to the model
      $updateResult = updateVehicle($invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

      // Check and report the result
      // Note, styling for $messages is using 'messageDiv' for sake of consolidation, even though name isn't accurate (because it's not a div)
      if($updateResult === 1){
      $message = "<p class='messageDiv'>Your vehicle '$invMake $invModel', was successfully updated.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
      } else { // If updateResult != 1
      $message = "<p class='messageDiv'>Sorry, your vehicle was not successfully modified.</p>";
      include '../view/vehicle-update.php';
      exit;
      }
        break;

  case 'del': // This is the modify button on the vehicle management page (injected from inventory.js into the table)
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if(count($invInfo)<1){
      $message = 'Sorry, no vehicle information could be found.';
     }
    include '../view/vehicle-delete.php';
    break;

  case 'deleteVehicle':
    // Filter and store the data
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));

    // Send the data to the model
    $deleteResult = deleteVehicle($invId);

    // Check and report the result
    // Note, styling for $messages is using 'messageDiv' for sake of consolidation, even though name isn't accurate (because it's not a div)
    if($deleteResult === 1){
    $message = "<p class='messageDiv'>Congratulations, the '$invMake $invModel' was successfully deleted.</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/vehicles/');
    exit;
    } else { // If deleteResult != 1
    $message = "<p class='messageDiv'>Sorry, your vehicle could not be successfully removed.</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/vehicles/');
    exit;
    }
          break;
  case 'classification': /* This control structure delivers the inventory items to the browser based upon what is clicked in the Navbar */
    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
    $vehicles = getVehiclesByClassification($classificationName);
    //print_r ($vehicles);
    if(!count($vehicles)){
     $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
     $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }
    // echo $vehicleDisplay;
    // exit;
    include '../view/classification.php';
    break;
  case 'vehicleInfo': /* This control structure shows vehicle information based on what inventory item is clicked on */
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $vehicleInfo = getVehicleByInvId($invId);
    $reviewInfo = getReviewByInventory($invId);

    //specific review in here.

    if(!count($vehicleInfo)){
      $message = "<p class='messageDiv'>Sorry, no vehicle information could be found.</p>";
     } else {
      $vehicleInfoDisplay = buildVehicleInfoDisplay($vehicleInfo);
      //print_r($reviewInfo); // this is working now
      $reviewInfoDisplay = buildReviewInfoDisplay($reviewInfo);
     }
    
     include '../view/vehicle-detail.php';
     break;

    break;
 default:
  $classificationList = buildClassificationList($classifications);
  include '../view/vehicle-man.php';
  break;
}