<?php
// Make sure the user is logged in; redirect to home if not
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors');
}
// $_SESSION['message'] = '<a href="/phpmotors/accounts">'
//     . 'WELCOME ' . $_SESSION['clientData']['clientFirstname']
//     . '</a>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | PHP Motors</title>

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
    <main>
        <h1>Manage Account</h1>
        <h2>Update Account</h2>
        <?php 
            if(isset($_SESSION['updateMessage'])) {
                echo "<p style='color:red'><em>" . $_SESSION['updateMessage'] ."</em></p>";
            }
        ?>
        <form method="post">

            <label for="firstName-input">First Name:</label>
            <input type="text" id="firstName-input" name="clientFirstname" placeholder="First Name" required <?php if (isset($_SESSION['clientData']['clientFirstname'])) {
                                                                                                                    $fName = $_SESSION['clientData']['clientFirstname'];
                                                                                                                    echo "value='$fName'";
                                                                                                                }  ?> />

            <label for="lastName-input">Last Name:</label>
            <input type="text" id="lastName-input" name="clientLastname" placeholder="lastName" required <?php if (isset($_SESSION['clientData']['clientFirstname'])) {
                                                                                                                $lName = $_SESSION['clientData']['clientLastname'];
                                                                                                                echo "value='$lName'";
                                                                                                            }  ?> />

            <label for="email-input">Email Address:</label>
            <input type="email" id="email-input" name="clientEmail" placeholder="email address" required <?php if (isset($_SESSION['clientData']['clientEmail'])) {
                                                                                                                $email = $_SESSION['clientData']['clientEmail'];
                                                                                                                echo "value='$email'";
                                                                                                            } ?> />

            <input type="submit" class="regbtn" name="submit" value="Update Info">
            <input type="hidden" name="action" value="update-info">
        </form>

        <form method="post">
            <label for="password-input">Password:</label>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
            <input type="password" id="password-input" name="clientPassword" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required />
            <input type="submit" class="regbtn" name="pwd-submit" value="Update Password">
            <input type="hidden" name="action" value="update-password">
        </form>

    </main>
    <?php
    require '../components/footer.php';
    ?>
</body>

</html>