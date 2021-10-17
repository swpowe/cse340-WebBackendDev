<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Create new classification.</title>
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
        <h2>Add Car Classification</h2>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <label for="clientClassification">Classification Name</label>
            <input type="text" id="clientClassification" name="clientClassification" />

            <input type="submit" value="Add Classification" />

            <input type="hidden" name="action" value="add-classification" />
        </form>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>