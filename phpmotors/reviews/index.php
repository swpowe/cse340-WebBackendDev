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
        $added = addReview("this is my 2nd review", 3, 3);
        if ($added === 1) {
            echo '<h1>Review added</h1>';
        } else {
            echo '<h1>something bad happened </h1>';
        }
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
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));



        // Send the data to the model
        $regOutcome = updateInfo($clientFirstname, $clientLastname, $clientEmail); //!! create in review Model

        // Check and report the result
        if ($regOutcome === 1) {
            //!! load new page and send message about successful update
            // // Set Cookie
            // setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');

            // $_SESSION['clientData']['clientFirstname'] = $clientFirstname;
            // $_SESSION['clientData']['clientLastname'] = $clientLastname;
            // $_SESSION['clientData']['clientEmail'] = $clientEmail;

            // $_SESSION['updateMessage'] = $_SESSION['clientData']['clientFirstname'] . ", your information has been updated.";
            // header('Location: /phpmotors/accounts/');
            exit;
        } else {
            //!! load new page error message
            // $updateMessage = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            // include '../view/user-management.php';
            exit;
        }

        //!! END COPIED

        echo '<h1>Updated your review</h1>';
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