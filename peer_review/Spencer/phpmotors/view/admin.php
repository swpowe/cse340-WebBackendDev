<?php
// Make sure the user is logged in; redirect to home if not
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors');
}
if (isset($_SESSION['updateMessage'])) {
    $updateMessage = $_SESSION['updateMessage'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Where parts are our game!</title>
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
        <?php
        // $_SESSION['messageData']['review'] = 'Initial Set';
        
        echo "
        <h1>" . $_SESSION['clientData']['clientFirstname'] . " "
            . $_SESSION['clientData']['clientLastname']
            .  "</h1>
            <h2> You are logged in.</h2>";
        if (isset($updateMessage)) {
            echo "<p style='color:red'><em> " . $updateMessage ."</em></p>";
        }

        echo "<ul>
                <li>First name: <em>" . $_SESSION['clientData']['clientFirstname'] . "</em></li>
                <li>Last name: <em>" . $_SESSION['clientData']['clientLastname'] . "</em></li>
                <li>Email: <em>" . $_SESSION['clientData']['clientEmail'] . "</em></li>
            </ul>
        <div class='user-management'>
            <h2>Account Management</h2>
            <h3>Use this link to update your account information.</h3>
            <a href='/phpmotors/accounts?action=user-management'>Update Account Information</a>
        </div>
            ";
        if ($_SESSION['clientData']['clientLevel'] > 1) {
            echo "<div class='vehicle-management'><h2>Inventory Management</h2><h3>Use this link to manage the inventory. </h3><a href='/phpmotors/vehicles'>Vehicle Management</a></div>";
        };
        // Add Users REVIEW MANAGEMENT section

        echo "<h2>Manage Your Reviews</h2>
        <h3 class='review-msg'>" .$_SESSION['messageData']['review']. "</h3>";
        buildReviewsView(); //!! do I have to pull this out??
        $_SESSION['messageData']['review'] = '';
        ?>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>