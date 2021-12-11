<?php 
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors/index.php'); 
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Managment - Grant Petersen</title>
    <link rel="stylesheet" href="../css/small.css">
</head>

<body>
    <header>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'; echo $header; ?>
    </header>

    <nav>
    <?php echo navList(); ?>
    </nav>

    <main>
        <h1><?php if (isset($_SESSION['clientData']['clientFirstname'])) {echo $_SESSION['clientData']['clientFirstname'];} ?> <?php echo $_SESSION['clientData']['clientLastname']; ?></h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <p>You are logged in.</p>
        <ul>
            <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
            <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
            <li>Email: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
        </ul>
        <h3>Account Management</h3>
        <p>Use this link to update account information.</p>
        <p><a href="/phpmotors/accounts?action=update-view">Update account information</a></p>
        <?php if ($_SESSION['clientData']['clientLevel'] != '1') {require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/privilege.php'; echo $privilege;}?>
        <h3>Written Reviews</h3>
        <?php $reviews = getReviewsByClient($_SESSION['clientData']['clientId']);
        echo buildClientsReviews($reviews); ?>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>
</body>

</html>