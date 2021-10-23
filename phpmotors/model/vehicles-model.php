<?php
// Vehicles Model

// add new vehicle
// add new classification

// function to handle adding a new car classification
function addClassification($clientClassification)
{
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO carclassification (classificationName) VALUES (:clientClassification)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientClassification', $clientClassification, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}

// function to handle adding a new vehicle
function addVehicle($clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId)
{

    echo "$clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId";
    // $db = phpmotorsConnect();
    // $sql = 'INSERT INTO vehicles (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) VALUES (:clientMake, :clientModel, :clientDescription, :clientImage, :clientThumbnail, :clientPrice, :clientStock, :clientColor, :classificationId)';
    // $stmt = $db->prepare($sql);
    // $stmt->bindValue(':clientMake', $$clientVehicle, PDO::PARAM_STR);

    // $stmt->execute();

    // $rowsChanged = $stmt->rowCount();
    // $stmt->closeCursor();

    return '$clientMake' . ' $clientModel' . ' $clientDescription' . ' $clientImage' . ' $clientThumbnail' . ' $clientPrice' . ' $clientStock' . ' $clientColor' . ' $classificationId';
}

?>


$sql = 'INSERT INTO clients (clientFirstname, clientLastname,clientEmail, clientPassword)
VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
// Create the prepared statement using the phpmotors connection
$stmt = $db->prepare($sql);
// The next four lines replace the placeholders in the SQL
// statement with the actual values in the variables
// and tells the database the type of data it is
$stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
$stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
$stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
$stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);