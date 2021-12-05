<?php
//?? This is the Reviews controller

// Get the database connection file
require_once '../library/connections.php';
// Get the Reviews Model
require_once '../model/reviews-model.php';
// echo '<h1>loaded</h1>';

// Filter action based off URL
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch($action) {
    case 'review-add': //### Add a new review ###
        $added = addReview("this is my 2nd review", 3, 3);
        if($added === 1) {
            echo '<h1>Review added</h1>';
        }else {
            echo '<h1>something bad happened </h1>';
        }
    break;

    case 'review-edit': //### Deliver a view to edit a review ###
        //!! need to pass in invId, clientId
        //!! pull review
        //!! pass to view for edit including reviewId
        //!! populate with passed data in the view
        echo '<h1>Edit your review</h1>';
    break;

    case 'review-update': //### Handle the review update ###
        //!! similar to review-add but update instead of insert
        //!! pass review, clientId, invId, reviewId
        echo '<h1>Updated your review</h1>';
    break;

    case 'review-del-conf': //### Deliver a view to confirm deletion of a review ###
        
        echo '<h1>Confirmation you want to delete your review?</h1>';
    break;

    case 'review-del': //### Handle the review deletion ###
        
        echo '<h1>Review deleted</h1>';
    break;


    default: //### Default delivers an admin view if logged in or php home if not ###
        echo '<h1>Default statement for reviews controller. No action specified</h1>';
    exit;
}
