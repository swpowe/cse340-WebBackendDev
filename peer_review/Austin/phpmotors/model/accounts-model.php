<?php
/*
 * Accounts Model
 */


 // Register a new client
function regClient($clientFirstName, $clientLastName, $clientEmail, $clientPassword){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstName, clientLastName,clientEmail, clientPassword)
        VALUES (:clientFirstName, :clientLastName, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
   }

   // Check for an existing email address
function checkExistingEmail($clientEmail) {
    $db =  phpmotorsConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if(empty($matchEmail)){
     return 0; // Nothing found
    } else {
     return 1; // Match found
    }
   }

   // Get client data based on an email address
function getClient($clientEmail){
    $db = phpmotorsConnect();
    // could use asterisk (all) here instead of listing all columns *shrug*
    $sql = 'SELECT clientId, clientFirstName, clientLastName, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
   }

function checkEmailUpdate($clientEmail, $clientId){
    $db =  phpmotorsConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email AND clientId <> :id'; //look for a matching email, but ALSO where the id doesn't match
    $stmt = $db->prepare($sql);                                                              //if the id does match, then this function should return a 0
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if(empty($matchEmail)){
     return 0; // Nothing found
    } else {
     return 1; // Match found
    }
}
    
 function updateUser($clientId, $clientFirstName, $clientLastName, $clientEmail){
     // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE clients SET clientFirstName = :clientFirstName, clientLastName = :clientLastName, clientEmail = :clientEmail WHERE clientId = :clientId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->bindValue(':clientFirstName', $clientFirstName, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastName', $clientLastName, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
 }

 function updatePassword($clientId, $hashedPassword){
    // Create a connection object using the phpmotors connection function
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'UPDATE clients SET clientPassword = :hashedPassword WHERE clientId = :clientId';
   // Create the prepared statement using the phpmotors connection
   $stmt = $db->prepare($sql);
   // The next four lines replace the placeholders in the SQL
   // statement with the actual values in the variables
   // and tells the database the type of data it is
   $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
   $stmt->bindValue(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
   // Insert the data
   $stmt->execute();
   // Ask how many rows changed as a result of our insert
   $rowsChanged = $stmt->rowCount();
   // Close the database interaction
   $stmt->closeCursor();
   // Return the indication of success (rows changed)
   return $rowsChanged;
}
