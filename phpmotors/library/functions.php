<?php

function dynamicNav($classifications)
{
    // Get the array of classifications
    // $classifications = getClassifications();

    // var_dump($classifications); // Testing Only. Returns DB object data
    // 	exit;

    // Build a navigation bar using the $classifications array
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
            . urlencode($classification['classificationName']) .
            "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';

    return $navList;
}


function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

// Build the classifications select list 
function buildClassificationList($classifications)
{
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}

function getVehiclesByClassification($classificationName)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

function buildVehiclesDisplay($vehicles)
{
    $dv = '<ul id="inv-display">';
    setlocale(LC_MONETARY, "en_US");
    foreach ($vehicles as $vehicle) {
        $price = "$" . number_format($vehicle['invPrice']);
        $href = '/phpmotors/vehicles?action=vehicle-detail&invId=' //!! problem in href. space somewhere.
            //!! probably need to NOT pass these and do a DB call
            . $vehicle['invId'];
        // . '&invMake=' . $vehicle['invMake']
        // . '&invModel=' . $vehicle['invModel']
        // . '&invDescription=' . $vehicle['invDescription']
        // . '&invImage=' . $vehicle['invImage']
        // . '&invPrice=' . $vehicle['invPrice']
        // . '&invStock=' . $vehicle['invStock']
        // . '&invColor=' . $vehicle['invColor'];

        $dv .= '<li>';
        $dv .= "<a href='$href'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='$href'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        // $dv .= "<h2>Vehicle ID: $vehicle[invId]</h2>";
        $dv .= "<span>$price</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetail($details)
{
    $price = "$" . number_format($details['invPrice']);
    $back = "/phpmotors/vehicles?action=classification&classificationName=$details[1]";

    //!! need to update array reference from index to named
    $dv = '<section class="detail-view">';
    $dv .= "<h1><span id='vehicle-make'>$details[invMake]</span> <span id='vehicle-model'>$details[invModel]</span></h1>";
    $dv .= "<div class='detail-view-details'>";
    $dv .= "<img class='detail-view-image' src='$details[invImage]' alt='Image of $details[invMake] $details[invModel] on phpmotors.com'>"; // img url
    $dv .= "<h2 >$details[invMake] $details[invModel] Details</h2>"; //!! NEED to change h3 styles so this works and isn't huge!
    $dv .= "<h3>$details[invDescription]</h3>";
    $dv .= "<h3>Price $price</h3>";
    $dv .= "<h3># in Stock: $details[invStock]</h3>";
    $dv .= "<h3>Color: $details[invColor]</h3>";
    // $dv .= "<a href='$back'>Back</a>";
    $dv .= "</div>";
    $dv .= "</section>";

    // add 
    if (isset($_SESSION['loggedin'])) {
        $dv .= buildAddReviewView();
    } else {
        $dv .= "<p>You must <a href='/phpmotors/accounts?action=login'>login</a> to write a review.</p>";
    }

    // add review here?
    $dv .= buildPreviewsReviews($details['invId']);
    // ??

    $_SESSION['vehicleData']['invId'] = $details['invId'];
    $_SESSION['vehicleData']['invMake'] = $details['invMake'];
    $_SESSION['vehicleData']['invModel'] = $details['invModel'];

    return $dv;
}

function vehicleDetailsByInvId($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT invMake, invModel FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $partialDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // returns invMake, invModel
    return $partialDetails;
}


// #region Review Specific Functions

function buildReviewsView()
{
    $clientId = $_SESSION['clientData']['clientId'];
    $reviews = getReviewsByClientId($clientId); //!! remove hard coded 3 !!


    // echo '<h2>Manage Your Reviews</h2>';
    echo '<ul class="user-review-list">';

    foreach ($reviews as $review => $r) {
        $timestamp = date('d M, Y', strtotime($r["reviewDate"]));
        # code...
        echo '<li>' .
            $r['invMake'] . ' ' . $r['invModel'] . ' (Reviewed on ' . $timestamp . '): ' .
            ' <a href="/phpmotors/reviews?action=review-edit&reviewId=' . $r["reviewId"] . '">Edit</a>
         | <a href="/phpmotors/reviews?action=review-delete-confirm&reviewId=' . $r["reviewId"] . '">Delete</a>
        </li>';

        // echo $r['reviewText'] .
        //     ' <a href="/phpmotors/reviews?action=review-edit&reviewId=' . $r["reviewId"] . '">Edit</a>
        //  | <a href="/phpmotors/reviews?action=review-del&reviewId=' . $r["reviewId"] . '">Delete</a>
        // <br/>';
    }
    echo '</ul>';
    // echo print_r($reviews);
    // use the clientId to get the reviews via the model based on the clientId

    // make, model, review date, edit btn, delete btn, (need to pass reviewId to button, need to pass reviewText to button)
}


function getReviewsByClientId($clientId)
{
    $db = phpmotorsConnect();
    // $sql = 'SELECT * FROM reviews WHERE clientId = :clientId';
    $sql = 'SELECT reviews.*, inventory.invMake, inventory.invModel FROM reviews JOIN inventory USING(invId) WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // returns reviews ARRAY of REVIEWS =>  reviewId, reviewText, reviewDate, invId, clientId, invMake, invModel
    return $reviews;
}

function getReviewByReviewId($reviewId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, inventory.invMake, inventory.invModel FROM reviews JOIN inventory USING(invId) WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);
    $stmt->execute();
    $review = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // returns reviewId, reviewText, reviewDate, invId, clientId, invMake, invModel

    // print_r($review);


    return $review;
}

function getReviewsByInvId($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT reviews.*, clients.clientFirstname, clients.clientLastname  FROM reviews JOIN clients USING(clientId)  WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // returns reviewId, reviewText, reviewDate, invId, clientId, invMake, invModel

    // print_r($reviews);

    return $reviews;
}

function buildAddReviewView()
{
    $make = $_SESSION['vehicleData']['invMake'];
    $model = $_SESSION['vehicleData']['invModel'];

    $username = substr($_SESSION['clientData']['clientFirstname'], 0, 1)
        . strtolower($_SESSION['clientData']['clientLastname']);
    $html = "<section class='reviews'><hr><h2>Customer Reviews</h2>";
    $html .= "<h3>Review the " . $make . " " . $model . "</h3>";
    $html .= "<div class='review'>";
    $html .= '<form class="review-form" action="/phpmotors/reviews/?action=review-add" method="POST">';
    $html .= '<label for="username">Screen Name: ';
    $html .= '<input id="username" type="text" value="' . $username . '" readonly>';
    $html .= '</label>';
    $html .= '<label for="review-text-box"> Review: ';
    $html .= $_SESSION['messageData']['review'];
    $html .= "<textarea rows='5' cols='60' id='review-text-box' name='review-text-box' required></textarea>";
    $html .= "</label>";
    
    $html .= '<button id="submit-review-button" type="submit" class="review-button">Submit Review</button>';
    $html .= '</form>';
    $html .= '</div>';
    $html .= '</section>';

    // change to if statement. If no reviews, return be the first to write review else return everything

    return $html;




    // <h2>Review the <car-name></h2>
    // <div class="review">
    //     <form action="/phpmotors/reviews?action=review-add" class="review-form">
    //         <!-- update form action passing in info from form -->
    //     <label for="username">
    //         Screen Name:
    //         <input id="username" type="text" value="USERNAME" readonly>
    //     </label>
    //     <label for="review-text">
    //         Review:
    //         <input type="text" id="review-text">
    //     </label>
    //     <button type="submit">Submit Review</button>
    //     </form>

    //     <p>Be the first to write a review.</p>
    // </div>

    // echo '<h1>Build Review Function </h1>';
}

function buildPreviewsReviews($invId)
{
    $reviews = getReviewsByInvId($invId);


    if (sizeof($reviews) <= 0) {
        $html = '<p class="first-review"><em>Be the first to write a review.</em></p>';
    } else {
        $html = "<ul class='review-list'>";

        foreach ($reviews as $review => $r) {
            $username = substr($r['clientFirstname'], 0, 1)
                . strtolower($r['clientLastname']);

            $timestamp = date('d M, Y', strtotime($r["reviewDate"]));

            $html .= "
            <li class='review-item'>
            <h3>Reviewed by  " . $username . " on " . $timestamp . "</h3>
            <p>
            $r[reviewText]
            </p>
            </li>";
        }
        $html .= "</ul>";
    }

    return $html;
}


// #endregion