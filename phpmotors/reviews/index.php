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
        $reviewText= trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING));

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
            header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' .$invId);
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
        echo print_r(INPUT_POST);

        // Filter and store the data
        $reviewText = trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        // $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        // $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));



        // Send the data to the model
        // $outcome = updateReview($reviewText, $reviewId); //!! create in review Model

        // Check and report the result
        // if ($regOutcome === 1) {
        //     //!! load new page and send message about successful update
        //     // // Set Cookie
        //     // setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');

        //     // $_SESSION['clientData']['clientFirstname'] = $clientFirstname;
        //     // $_SESSION['clientData']['clientLastname'] = $clientLastname;
        //     // $_SESSION['clientData']['clientEmail'] = $clientEmail;

        //     // $_SESSION['updateMessage'] = $_SESSION['clientData']['clientFirstname'] . ", your information has been updated.";
        //     // header('Location: /phpmotors/accounts/');
        //     exit;
        // } else {
        //     //!! load new page error message
        //     // $updateMessage = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
        //     // include '../view/user-management.php';
        //     exit;
        // }

        //!! END COPIED

        echo '<h1>Updated your review ID ' .$reviewText . '</h1>';
        break;

    case 'review-del-conf': //### Deliver a view to confirm deletion of a review ###

        echo '<h1>Confirmation you want to delete your review?</h1>';
        break;

    case 'review-del': //### Handle the review deletion ###
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        // echo '<h1>Confirm review deletion. Review Id = ' .$reviewId.'.</h1>';
        $reviewDetails = getReviewByReviewId($reviewId); //!! FAILS??
        include '../view/review-delete.php';
        break;


    default: //### Default delivers an admin view if logged in or php home if not ###
        echo '<h1>Default statement for reviews controller. No action specified</h1>';
        exit;
}
