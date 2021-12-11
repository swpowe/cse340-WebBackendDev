<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}
?>
<!DOCTYPE html>
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
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
        echo $header; ?>
    </header>

    <nav>
    <?php echo navList(); ?>
    </nav>

    <main>
        <h1>What would you like to do? <br></h1>
        <?php if (isset($message)) {
            echo $message;
        }
        ?>
        <p><a href="/phpmotors/vehicles?action=addClassification">Add a classification</a></p>
        <p><a href="/phpmotors/vehicles/?action=addVehicle">Add a vehicle</a></p>

        <?php
        if (isset($classificationList)) {
            echo '<h2>Vehicles By Classification</h2>';
            echo '<p>Choose a classification to see those vehicles</p>';
            echo $classificationList;
        }
        ?>
        <noscript>
            <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
        </noscript>
        <table id="inventoryDisplay"></table>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. </br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.</br>
            Last Updated: </p>
    </footer>
    <script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>