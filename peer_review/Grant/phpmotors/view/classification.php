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

    <main>
        <h1><?php echo $classificationName; ?> vehicles</h1>
        <?php if (isset($message)) {
            echo $message;
        } ?>
        <?php if (isset($vehicleDisplay)) {
            echo $vehicleDisplay;
        } ?>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. </br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.</br>
            Last Updated: </p>
    </footer>
</body>

</html>