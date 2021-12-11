<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Error page.</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
    <link rel="stylesheet" href="/phpmotors/css/medium.css">
    <link rel="stylesheet" href="/phpmotors/css/large.css">
    <link rel="stylesheet" href="/phpmotors/css/xtra-large.css">
</head>


<body>
    <?php
    require '../components/header.php';
    ?>
    <?php
    require '../components/nav.php';
    ?>
    <?php
    echo
    " <main>
    <section class='error-msg'>
    <h1> Server Error. </h1>
    <h2> Sorry our server seems to be expereienceing some technical difficulties. </h2>
    </section>
    </main> ";
    ?>
    <?php
    require '../components/footer.php';
    ?>
</body>

</html>