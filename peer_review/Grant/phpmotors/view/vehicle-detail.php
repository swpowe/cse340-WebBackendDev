<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
    <link rel="stylesheet" href="../css/small.css">
</head>

<body>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
        echo $header; ?>
    </header>

    <nav>
        <?php echo navList(); ?>
    </nav>

    <main id="detail-main">
        <h1><?php echo $vehicle[0]['invMake'] . ' ' . $vehicle[0]['invModel']; ?></h1>
        <?php if (isset($message)) {
            echo $message;
        }
        // if (isset($_SESSION['message'])) {
        //     echo $_SESSION['message'];
        // } 
        ?>
        <?php if (isset($vehicleDetail)) {
            echo $vehicleDetail;
        } ?>
        <h2>Customer Reviews</h2>
        <?php
        if (isset($_SESSION['loggedin'])) {
            $reviewForm = "<form action='/phpmotors/reviews/index.php' method='post'>
            <textarea type='text' name='reviewText' id='reviewText' required placeholder='Write your review of this product here...'></textarea><input type='hidden' name='action' value='addReview'><input type='hidden' name='invId' value='" . $vehicle[0]['invId'] . "'><input type='hidden' name='clientId' value='" . $_SESSION['clientData']['clientId'] . "'><br><p>Your review will be signed with your screen name: " . substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'] . "</p><input type='submit' name='submit' value='Submit Review'>
            </form>";
            echo $reviewForm;
        } else {
            $login = "<p><a href='/phpmotors/accounts?action=login-page'>Click here</a> to log in so you can write your own review of this product.</p>";
            echo $login;
        }
        ?>
        <?php if (isset($reviewMessage)) {
            echo $reviewMessage;
        } else {
            echo $reviewList;
        } ?>

    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>
</body>

</html>