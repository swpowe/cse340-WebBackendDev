<?php
// Make sure the user is logged in AND is an Admin; redirect to home if not
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 3) {
    header('Location: /phpmotors');
}
if (isset($_SESSION['message'])) {
    echo 'problem';
    $message = $_SESSION['message'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Vehicles Manager.</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
    <link rel="stylesheet" href="/phpmotors/css/medium.css">
    <link rel="stylesheet" href="/phpmotors/css/large.css">
    <link rel="stylesheet" href="/phpmotors/css/xtra-large.css">

</head>


<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/header.php'
    ?>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h1>Vehicle Management</h1>
        <p><a href="/phpmotors/vehicles?action=add-vehicle-page">Add Vehicle Page</a></p>
        <p><a href="/phpmotors/vehicles?action=add-classification-page">Add Classification Page</a></p>

        <?php
        if (isset($message)) {
            echo $message;
        }
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
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
    <script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>