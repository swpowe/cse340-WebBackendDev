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
            . $vehicle['invId']
            . '&invMake=' . $vehicle['invMake']
            . '&invModel=' . $vehicle['invModel']
            . '&invDescription=' . $vehicle['invDescription']
            . '&invImage=' . $vehicle['invImage']
            . '&invPrice=' . $vehicle['invPrice']
            . '&invStock=' . $vehicle['invStock']
            . '&invColor=' . $vehicle['invColor'];

        $dv .= '<li>';
        $dv .= "<a href='$href'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='$href'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $dv .= "<h2>Vehicle ID: $vehicle[invId]</h2>";
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
    $dv .= "<h1>$details[invMake] $details[invModel]</h1>";
    $dv .= "<div class='detail-view-details'>";
    $dv .= "<img class='detail-view-image' src='$details[invImage]'>"; // img url
    $dv .= "<h3 >$details[invMake] $details[invModel] Details</h3>"; //!! NEED to change h3 styles so this works and isn't huge!
    $dv .= "<h3>$details[invDescription]</h3>";
    $dv .= "<h3>Price $price</h3>";
    $dv .= "<h3># in Stock: $details[invStock]</h3>";
    $dv .= "<h3>Color: $details[invColor]</h3>";
    // $dv .= "<a href='$back'>Back</a>";
    $dv .= "</div>";
    $dv .= "</section>";

    return $dv;
}