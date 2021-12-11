<?php
// <!-- This is the Reviews Controller -->
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/reviews-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';

$navList = navList();


// for adding reviews to the database
$reviewText = filter_input(INPUT_POST, 'reviewText');
// $reviewDate = filter_input(INPUT_POST, 'reviewDate');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    //<!-- Add a new review -->
    case 'addReview':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if (empty($reviewText) || empty($invId) || empty($clientId)) {
            $message = '<p>Please type your review before submitting.</p>';
            header("location: /phpmotors/vehicles/index.php?action=detail&invId=$invId");
            exit;
        }

        $screenName = substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'];
        $reviewText .= ' --';
        $reviewText .= $screenName;

        $reviewCheck = addReview($reviewText, $invId, $clientId);

        if ($reviewCheck === 1) {
            $message = '<p>Your review has been successfully submited. Thank you for your time.</p>';
            // $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/index.php?action=detail&invId=$invId");
            exit;
        } else {
            $message = '<p>Your review could not be processed, tech support will be notified and resolve the issue.</p>';
            header("location: /phpmotors/vehicles/index.php?action=detail&invId=$invId");
            exit;
        }
        break;

//<!-- deliver a view to edit a review -->
    case 'editReview':
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        $reviewInfo = getReviewInfo($reviewId);
        if (!$reviewInfo) {
            $message = '<p>Sorry, no review information was retrieved.</p>';
        }
        include '../view/review-update.php';
        break;

//<!-- update a review -->
case 'updateReview':
    $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
    $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
    $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
    $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));

    if (empty($reviewText) ||empty($reviewId)) {
        $message = '<p>If you would like to delete your review, click the delete button.</p>';
        include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/review-update.php';
        exit;
    }
    $reviewInfo = getReviewInfo($reviewId);

    $reviewCheck = updateReview($reviewText, $reviewId);

    if ($reviewCheck) {
        $message = '<p>Your review has been successfully updated. Thank you for your time.</p>';
        // header('location: /phpmotors/accounts/');
        include '../accounts/index.php';
        exit;
    } else {
        $message = '<p>Your review could not be updated, tech support will be notified and resolve the issue.</p>';
        include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/update-review.php';
        exit;
    }
    break;


//<!-- deliver view to confirm review deletion -->
case 'delReview':
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    $reviewInfo = getReviewInfo($reviewId);
    if (!$reviewInfo) {
        $message = '<p>Sorry, no review was found.</p>';
    }
    include '../view/review-delete.php';
    exit;
    break;


//<!-- handle review deletion -->
case 'deleteReview':
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteReview($reviewId);

    if ($deleteResult) {
        $message = "<p>Review was successfully deleted.</p>";
        $_SESSION['message'] = $message;
        // header('location: /phpmotors/accounts/');
        include '../accounts/index.php';
        exit;
    } else {
        $message = "<p>Error: review was not deleted.</p>";
        $_SESSION['message'] = $message;
        header('location: /phpmotors/accounts/');
        exit;
    }
    break;

//<!-- default deliver admin view if logged in or home biew if not -->
    default:
        include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/admin.php';
    }