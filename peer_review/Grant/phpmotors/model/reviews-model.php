<?php
//<!-- Insert a review -->
function addReview($reviewText, $invId, $clientId)
{
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId) VALUES (:reviewText, :invId, :clientId)';
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


//<!-- get reviews for specific item -->
// function getReviewsByItem($invId) 
// {
//     $db = phpmotorsConnect();
//     $sql = 'SELECT * FROM reviews WHERE invId = :invId ORDER BY reviewDate';
//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
//     $stmt->execute();
//     $itemReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $stmt->closeCursor();
//     return $itemReviews;
// }


// //<!-- get reviews written by specific client -->
// function getReviewsByClient($clientId) 
// {
//     $db = phpmotorsConnect();
//     $sql = 'SELECT * FROM reviews WHERE clientId = :clientId';
//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
//     $stmt->execute();
//     $clientsReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $stmt->closeCursor();
//     return $clientsReviews;
// }


//<!-- get specific review -->
function getReviewInfo($reviewId) 
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $reviewInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviewInfo;
}


//<!-- Update specific review -->
function updateReview($reviewText, $reviewId)
{
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);

    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


//<!-- Delete specific review -->
function deleteReview($reviewId)
{
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;

}