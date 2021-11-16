<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css">

</head>


<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/header.php'
    ?>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h1><?php echo $classificationName; ?> vehicles</h1>
        <?php if (isset($message)) {
            echo $message;
        }
        ?>
        <?php if (isset($vehicleDisplay)) {
            echo $vehicleDisplay;
        } ?>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>