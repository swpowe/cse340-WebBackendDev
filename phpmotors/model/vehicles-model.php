<?php
// Vehicles Model

// add new vehicle
// add new classification

// function to handle adding a new car classification
function addClassification($clientClassification) {
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
function addVehicle() {

}

?>