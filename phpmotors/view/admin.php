<?php
// Make sure the user is logged in; redirect to home if not
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors');
}
$_SESSION['message'] = '<a href="/phpmotors/accounts">'
    . 'WELCOME ' . $_SESSION['clientData']['clientFirstname']
    . '</a>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Where parts are our game!</title>
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
        <?php
        echo '
            <h1>' . $_SESSION['clientData']['clientFirstname'] . ' '
            . $_SESSION['clientData']['clientLastname']
            .  '</h1>
            <h2> You are logged in.</h2>
            <ul>
                <li>First name: <em>' . $_SESSION['clientData']['clientFirstname'] . '</em></li>
                <li>Last name: <em>' . $_SESSION['clientData']['clientLastname'] . '</em></li>
                <li>Email: <em>' . $_SESSION['clientData']['clientEmail'] . '</em></li>
            </ul>
        ';

        if ($_SESSION['clientData']['clientLevel'] > 1) {
            echo "<p><a href='/phpmotors/vehicles'>Vehicle Management</a></P";
        };
        ?>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>