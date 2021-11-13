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

    // echo "$clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId"; //!! Testing ONLY

    $db = phpmotorsConnect();
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId) VALUES (:clientMake, :clientModel, :clientDescription, :clientImage, :clientThumbnail, :clientPrice, :clientStock, :clientColor, :classificationId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientMake', $clientMake, PDO::PARAM_STR);
    $stmt->bindValue(':clientModel', $clientModel, PDO::PARAM_STR);
    $stmt->bindValue(':clientDescription', $clientDescription, PDO::PARAM_STR);
    $stmt->bindValue(':clientImage', $clientImage, PDO::PARAM_STR);
    $stmt->bindValue(':clientThumbnail', $clientThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPrice', $clientPrice, PDO::PARAM_STR);
    $stmt->bindValue(':clientStock', $clientStock, PDO::PARAM_STR);
    $stmt->bindValue(':clientColor', $clientColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);


    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    // return '$clientMake' . ' $clientModel' . ' $clientDescription' . ' $clientImage' . ' $clientThumbnail' . ' $clientPrice' . ' $clientStock' . ' $clientColor' . ' $classificationId'; //!! Testing ONLY

    return $rowsChanged;
}

// function to handle updating a new vehicle
function updateVehicle($invId, $classificationId, $clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor)
{

    // echo "$clientMake, $clientModel, $clientDescription, $clientImage, $clientThumbnail, $clientPrice, $clientStock, $clientColor, $classificationId"; //!! Testing ONLY

    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, 
	invDescription = :invDescription, invImage = :invImage, 
	invThumbnail = :invThumbnail, invPrice = :invPrice, 
	invStock = :invStock, invColor = :invColor, 
	classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientMake', $clientMake, PDO::PARAM_STR);
    $stmt->bindValue(':clientModel', $clientModel, PDO::PARAM_STR);
    $stmt->bindValue(':clientDescription', $clientDescription, PDO::PARAM_STR);
    $stmt->bindValue(':clientImage', $clientImage, PDO::PARAM_STR);
    $stmt->bindValue(':clientThumbnail', $clientThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPrice', $clientPrice, PDO::PARAM_STR);
    $stmt->bindValue(':clientStock', $clientStock, PDO::PARAM_STR);
    $stmt->bindValue(':clientColor', $clientColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);


    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    // return '$clientMake' . ' $clientModel' . ' $clientDescription' . ' $clientImage' . ' $clientThumbnail' . ' $clientPrice' . ' $clientStock' . ' $clientColor' . ' $classificationId';

    return $rowsChanged;
}

// Get vehicles by classificationId 
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

// Get vehicle information by invId
function getInvItemInfo($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}
