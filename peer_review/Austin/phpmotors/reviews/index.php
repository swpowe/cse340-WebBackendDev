<?php
/********************************
 * Controller for Reviews file
 *******************************/

 // create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model in order to use associated functions for SQL functionality
require_once '../model/vehicles-model.php';
// Get the functions file
require_once '../library/functions.php';
// Get reviews model
require_once '../model/reviews-model.php';


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
  case 'insert-review':
    //Filter and Store data
    $reviewText = filter_input(INPUT_POST, 'reviewText');
    $invId = filter_input(INPUT_POST, 'invId');
    $clientId = filter_input(INPUT_POST, 'clientId');

    // To help test crap
    //$vehicleInfo = getVehicleByInvId($invId);

    //TEST CRAP
    // echo "CLIENT ID EQUALS: " . $clientId;
    // echo "INV ID EQUALS: " . $invId;
    // print_r ($vehicleInfo);

      // Check for missing data
      if(empty($reviewText)){
        $message = "<p>Your review can't be empty.</p>";
        $_SESSION['message'] = $message;
        header("location: /phpmotors/vehicles/?action=vehicleInfo&invId=$invId");
        exit; 
      }

    
      // Send the data to the model
      $addReviewOutcome = insertReview($invId, $clientId, $reviewText);

      if($addReviewOutcome === 1){
        $message = "<p>Thanks for the review, it is displayed below.</p>";
        $_SESSION['message'] = $message;
        header("location: /phpmotors/vehicles/?action=vehicleInfo&invId=$invId");
        exit; 
      } else {
        $message = "<p>Sorry, your review could not be added.</p>";
        $_SESSION['message'] = $message;
        header("location: /phpmotors/vehicles/?action=vehicleInfo&invId=$invId");
        exit; 
      }
        break;

    include '../view/vehicle-detail.php';
    // See vehicle index @ line 95+
    break;

  case 'edit-review':
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    $entireReview = getReviewbyId($reviewId);
    $vehicleNameArray = getVehicleByInvId($entireReview['invId']);

    // if(isset($reviewId)){
    //   $message = "<p>Your review is going through</p>";
    //   $_SESSION['message'] = $message;
    //   include '../view/review-update.php';
    // } else {
    //   $message = "<p>Your review being dumb.</p>";
    //   $_SESSION['message'] = $message;
    //   include '../view/review-update.php';
    // }
    if(count($entireReview)<1){
      $message = 'Sorry, no review information could be found.';
      $_SESSION['message'] = $message;
     }
     include '../view/review-update.php';

    break;
    



  case 'handle-review-update':
    // Filter incoming data, just reviewId and the new reviewText to replace the old
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
    $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
    //echo "This is the reviewId: ".$reviewId; //This is the problem

    // Server side validation
    if(empty($reviewText)){
    $message = '<p>Review cannot be empty.</p>';
    $_SESSION['message'] = $message;
    include "/phpmotors/reviews/?action=edit-review&reviewId=$reviewId";
    exit; 
    }
    // Send to model for SQL query
    $reviewUpdateResult = updateReview($reviewId, $reviewText);
    //echo "This is the rows changed: ".$reviewUpdateResult; // Any rows changed?

    if($reviewUpdateResult === 1){
      $message = "<p class='messageDiv'>Your review was successfully updated.</p>";
      $_SESSION['message'] = $message;
      include '../view/admin.php';
      exit;
      } else { // If updateResult != 1
      $message = "<p class='messageDiv'>Sorry, your review was not successfully updated.</p>";
      $_SESSION['message'] = $message;
      include '../view/admin.php';
      exit;
      }

      break;
    
  case 'confirm-review-delete':
    // filter incoming data
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    //get the entire review that we want to delete
    $entireReview = getReviewbyId($reviewId);
    $vehicleNameArray = getVehicleByInvId($entireReview['invId']);

    if(count($entireReview)<1){
      $message = 'Sorry, no review information could be found.';
      $_SESSION['message'] = $message;
     }
     include '../view/review-delete.php';

    break;

  case 'handle-review-delete':
    //Get reviewId for the review that will be evicerated
    //echo "This is the review ID: ".$reviewId;
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
    //Call delete function
    $deleteResult = deleteReview($reviewId);
    //Make sure delete was successful
    if($deleteResult === 1){
      $message = "<p class='messageDiv'>The review was successfully deleted.</p>";
      $_SESSION['message'] = $message;
      include '../view/admin.php';
      exit;
      } else { // If deleteResult != 1
      $message = "<p class='messageDiv'>Sorry, The review could not be successfully deleted.</p>";
      $_SESSION['message'] = $message;
      include '../view/admin.php';
      exit;
      }
            break;

    include '../view/vehicle-detail.php';

    break;

  default:
  if(isset($_SESSION['loggedin'])) { //check if user is logged, I think this is the right session variable.
  include '../view/admin.php';
   } else {
  include '../view/home.php';}
  
  break;
 }