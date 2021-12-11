<?php
function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function navList()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';

    $classifications = getClassifications();

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

function getInventoryByClassification($classificationId)
{
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

function buildVehiclesDisplay($vehicles)
{
    $dv = "<ul id='inv-display'>";
    foreach ($vehicles as $vehicle) {
        $dv .= '<li>';
        $dv .= "<a href='/phpmotors/vehicles?action=detail&invId=" . urlencode($vehicle['invId']) . "' title='View details'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='/phpmotors/vehicles?action=detail&invId=" . urlencode($vehicle['invId']) . "' title='View details'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $dv .= "<span>$" . number_format($vehicle['invPrice'], 2) . "</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehiclesDetail($vehicle)
{
    $vehicleArray = $vehicle[0];
    $dv = "<div id='detail-page'>";
    $dv .= "<img id='detail-image' src='$vehicleArray[invImage]' alt='Picture of a $vehicleArray[invMake] $vehicleArray[invModel]'>";
    $dv .= "<div id='detail-info'>";
    $dv .= "<h2>$vehicleArray[invMake] $vehicleArray[invModel]</h2>";
    $dv .= "<span>$" . number_format($vehicleArray['invPrice'], 2) . "</span>";
    $dv .= "<p>\"$vehicleArray[invDescription]\"</p>";
    $dv .= "<p>In Stock: $vehicleArray[invStock]</p>";
    $dv .= "<p>Color: $vehicleArray[invColor]</p>";
    $dv .= "</div>"."</div>";
    return $dv;
}

function getReviewsByItem($invId) 
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE invId = :invId ORDER BY reviewDate';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $itemReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $itemReviews;
}

function getReviewsByClient($clientId) 
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $clientsReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientsReviews;
}


function buildReviews($reviews) 
{
    $dv = "<div id='reviews'><ul>";
    foreach ($reviews as $review) {
        $stamp = $review['reviewDate'];
        $date = date("m/d/Y", strtotime($stamp));
        $dv .= '<li>';
        $dv .= $date;
        $dv .= ' -- ';
        $dv .= $review['reviewText'];
        $dv .= '</li>';
    }
    $dv .= '</ul></div>';
    return $dv;
}

function buildClientsReviews($reviews) 
{
    $dv = "<div id='reviews'><ul>";
    foreach ($reviews as $review) {
        $stamp = $review['reviewDate'];
        $date = date("m/d/Y", strtotime($stamp));
        $dv .= '<li>';
        $dv .= $date;
        $dv .= ' -- ';
        $dv .= substr($review['reviewText'], 0, 17);
        $dv .= "...   <a href='/phpmotors/reviews?action=editReview&reviewId=" . urlencode($review['reviewId']) . "'>Edit</a>";
        $dv .= "   <a href='/phpmotors/reviews?action=delReview&reviewId=" . urlencode($review['reviewId']) . "'>Delete</a>";
        $dv .= '</li>';
    }
    $dv .= '</ul></div>';
    return $dv;
}