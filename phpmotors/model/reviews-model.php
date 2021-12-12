<?php 
//?? Reviews Model

//>> Insert a review <<
function addReview($reviewText, $invId, $clientId) {
    // filter input from passed form
    
    $db = phpmotorsConnect();
    // !! Testing Only 
    // $reviewText = 'This is a brand new review.';
    // $invId = 2;
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

function updateReview($reviewText, $reviewId) {

    $db = phpmotorsConnect();

    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}

function deleteReview($reviewId) {

    $db = phpmotorsConnect();

    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_STR);

    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();

    return $rowsChanged;
}
