<?php
//?? This is the Reviews controller
// Create or Access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the Reviews Model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';
// echo '<h1>loaded</h1>';

// Filter action based off URL
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'review-add': //### Add a new review ###
        // save inputs to variables
        $invId = $_SESSION['vehicleData']['invId']; //!! should I pass these instead?
        // $invMake = $_SESSION['vehicleData']['invId'];
        // $invModel = $_SESSION['vehicleData']['invId'];
        $clientId = $_SESSION['clientData']['clientId'];
        $reviewText = trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING));

        // send to database
        $outcome = addReview($reviewText, $invId, $clientId);

        if ($outcome === 1) {
            // $message = "<h2 class=\"status-good\">New vehicle $clientMake:$clientModel added to the inventory. </h2>";
            // echo $invId;
            // echo 'worked';
            // echo $outcome;
            // include '../phpmotors/vehicles/?action=vehicle-detail&invId=2';
            // include '../vehicles?action=vehicle-detail&invId=2';
            // !! send car details?
            // include '../vehicles/index.php';
            header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' . $invId);
            exit;
        } else {
            // $message = "<h2 class=\"status-error\">There was a problem adding $clientMake:$clientModel to the inventory. Please try again. </h2>";
            // include '../view/add-vehicle.php';
            echo 'problem';
            exit;
        }
        // include('../vehicles?action=vehicle-detail&invId=' .$invId);
        break;

    case 'review-edit': //### Deliver a view to edit a review ###
        //!! need to pass in invId, clientId
        //!! pull review
        //!! pass to view for edit including reviewId
        //!! populate with passed data in the view
        // echo '<h1>Edit your review</h1>';
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        $reviewDetails = getReviewByReviewId($reviewId);
        include '../view/review-edit.php';
        break;

    case 'review-update': //### Handle the review update ###
        //!! similar to review-add but update instead of insert
        //!! pass review, clientId, invId, reviewId

        //!! COPIED
        // echo 'Update Info Page';

        // Filter and store the data
        $reviewText = trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        // $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        // $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));



        // Send the data to the model
        $outcome = updateReview($reviewText, $reviewId); //!! create in review Model

        echo $outcome;

        if ($outcome === 1) {
            //!! load previous page and send message about successful update
            // http://localhost/phpmotors/reviews/?action=review-edit&reviewId=11
            // header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' .$_SESSION['vehicleData']['invId']); // don't have the invId?
            // Set message. Show message based on previous page?

            //!! will edits only happen on users management page?
            $_SESSION['messageData']['review'] = "Your review has been updated successfully."; //!! Message on what was updated
            header('Location:/phpmotors/accounts/');
            exit;
        } else {
            //!! load new page error message
            // $updateMessage = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            // include '../view/user-management.php';
            exit;
        }

        // echo '<h1>Updated your review ID ' .$reviewText .  $reviewId. '</h1>';
        break;
    case 'review-delete-confirm': //### Handle the review deletion ###
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        // echo '<h1>Confirm review deletion. Review Id = ' .$reviewId.'.</h1>';
        $reviewDetails = getReviewByReviewId($reviewId); //!! FAILS??
        include '../view/review-delete.php';
        break;



    case 'review-delete': //### Deliver a view to confirm deletion of a review ###

        // Filter and store the data
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        // echo 'review ID 2: ' . $reviewId;
        // Send the data to the model
        $outcome = deleteReview($reviewId); //!! create in review Model

        echo $outcome;

        if ($outcome === 1) {
            //!! load previous page and send message about successful update
            // http://localhost/phpmotors/reviews/?action=review-edit&reviewId=11
            // header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' .$_SESSION['vehicleData']['invId']); // don't have the invId?
            // Set message. Show message based on previous page?

            //!! will edits only happen on users management page?
            $_SESSION['messageData']['review'] = "Your review has been deleted successfully."; //!! Message on what was updated
            header('Location:/phpmotors/accounts/');
            exit;
        } else {
            //!! load new page error message
            // $updateMessage = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            // include '../view/user-management.php';
            echo 'Del Failed';
            exit;
        }

        // echo '<h1>Updated your review ID ' .$reviewText .  $reviewId. '</h1>';
        break;


    default: //### Default delivers an admin view if logged in or php home if not ###
        echo '<h1>Default statement for reviews controller. No action specified</h1>';
        exit;
}
