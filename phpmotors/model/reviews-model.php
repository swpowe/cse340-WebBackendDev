<?php 
//?? Reviews Model

//>> Insert a review <<
function addReview($reviewText, $invId, $clientId) {
    $db = phpmotorsConnect();

    // !! Testing Only 
    // $reviewText = 'This is my first review.';
    // $invId = 3;
    // $clientId = 3;

    $sql = 'INSERT INTO reviews (reviewText, reviewDate, invId, clientId)
     VALUES (:reviewText, now(), :invId, :clientId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}


//>> Get reviews for a specific inventory item <<


//Get reviews written by a specific client
//Get a specific review
//Update a specific review
//Delete a specific review

?>