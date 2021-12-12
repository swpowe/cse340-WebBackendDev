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
        $clientId = $_SESSION['clientData']['clientId'];
        $reviewText = trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING));

        // !! error checking
        if (empty($clientId) || empty($reviewText)) {
            if($invId) {
                $_SESSION['messageData']['review'] = '<p class="review-message-error">Please provide text for your review.</p>';
            include '../view/registration.php';
            header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' .$invId);
            exit;
            } else {
                $_SESSION['messageData']['review'] = 'No valid invId provided. Check your session.';
            }
        }

        // send to database
        $outcome = addReview($reviewText, $invId, $clientId);

        if ($outcome === 1) {
            $_SESSION['messageData']['review'] = '<p class="review-message-success">Your review has successfully been added.</p>';
            header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' . $invId);
            exit;
        } else {
            $_SESSION['messageData']['review'] = '<p class="review-message-error">There was a problem adding your review. Please try again.</p>';
            header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId=' . $invId);
            exit;
        }
        break;

    case 'review-edit': //### Deliver a view to edit a review ###
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        $reviewDetails = getReviewByReviewId($reviewId);
        include '../view/review-edit.php';
        break;

    case 'review-update': //### Handle the review update ###

        // Filter and store the data
        $reviewText = trim(filter_input(INPUT_POST, 'review-text-box', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??

        if($reviewText === '') {
            $_SESSION['messageData']['review'] = "Review text was empty. Please provide a review."; //!! Message on what was updated
            header('Location: /phpmotors/reviews/?action=review-edit&reviewId=' .$reviewId);
            exit;
        }


        // Send the data to the model
        $outcome = updateReview($reviewText, $reviewId); //!! create in review Model

        if ($outcome === 1) {
            $_SESSION['messageData']['review'] = "Your review has been updated successfully."; //!! Message on what was updated
            header('Location:/phpmotors/accounts/');
            exit;
        } else {
            $_SESSION['messageData']['review'] = "There was a problem updating your review. Please try again."; //!! Message on what was updated
            header('Location: /phpmotors/reviews/?action=review-edit&reviewId=' .$reviewId);
            exit;
        }

        break;
    case 'review-delete-confirm': //### Handle the review deletion ###
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_STRING);
        $reviewDetails = getReviewByReviewId($reviewId); //!! FAILS??
        include '../view/review-delete.php';
        break;



    case 'review-delete': //### Deliver a view to confirm deletion of a review ###

        // Filter and store the data
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING)); //!! need reviewId and reviewText only right??
        $outcome = deleteReview($reviewId); //!! create in review Model

        echo $outcome;

        if ($outcome === 1) {
            $_SESSION['messageData']['review'] = "Your review has been deleted successfully."; //!! Message on what was updated
            header('Location:/phpmotors/accounts/');
            exit;
        } else {
            $_SESSION['messageData']['review'] = "There was a problem deleting your review. Please try again."; //!! Message on what was updated
            header('Location: /phpmotors/reviews/?action=review-edit&reviewId=' .$reviewId);
            exit;
        }

        break;


    default: //### Default delivers an admin view if logged in or php home if not ###
        echo '<h1>Default statement for reviews controller. No action specified</h1>';
        exit;
}
