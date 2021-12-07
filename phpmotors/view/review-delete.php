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
        <h1>Review Delete Page</h1>
        <?php
           if (isset($reviewDetails)) {
                // echo print_r($reviewDetails);
                echo '<h1>' .$reviewDetails[0]["reviewText"]. '</h1>';
            }else {
                echo '<h1>No details? </h1>';
            }
        // echo 'driving me crazy!';
        ?>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>