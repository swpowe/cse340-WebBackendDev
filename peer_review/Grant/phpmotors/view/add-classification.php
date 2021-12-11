<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Home - Grant Petersen</title>
    <link rel="stylesheet" href="../css/small.css">
</head>

<body>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
        echo $header; ?>
    </header>

    <nav><?php echo navList(); ?></nav>

    <main>
        <h1>Add Car Classification</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <label for="classificationName">Classification Name</label><br>
            <input type="text" name="classificationName" id="classificationName" pattern="{,30}" required><br>
            <span>No more than 30 characters.</span><br>
            <input type="submit" name="submit" id="add-btn" value="Add Classification">
            <input type="hidden" name="action" value="addClassification">
        </form>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>

</body>

</html>