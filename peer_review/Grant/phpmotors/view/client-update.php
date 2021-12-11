<?php
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Managment - Grant Petersen</title>
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
        <h1>Manage Account</h1>
        <h3>Update Account</h3>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>

        <form action="/phpmotors/accounts/index.php" method="post">
            <fieldset>
                <label for="firstName">First Name:</label><br>
                <input type="text" id="firstName" name="clientFirstname" value="<?php if (isset($_SESSION['clientData']['clientFirstname'])) {
                                                                                    echo $_SESSION['clientData']['clientFirstname'];
                                                                                } ?>" required><br>
                <label for="lastName">Last Name:</label><br>
                <input type="text" id="lastName" name="clientLastname" value="<?php if (isset($_SESSION['clientData']['clientLastname'])) {
                                                                                    echo $_SESSION['clientData']['clientLastname'];
                                                                                } ?>" required><br>
                <label for="email">Email Address:</label><br>
                <input type="email" id="email" name="newClientEmail" value="<?php if (isset($_SESSION['clientData']['clientEmail'])) {
                                                                                echo $_SESSION['clientData']['clientEmail'];
                                                                            } ?>" required><br>
                <input type="submit" name="submit" value="Update Info">
                <input type="hidden" name="action" value="update-client">
                <input type="hidden" name="clientId" value="<?php if (isset($_SESSION['clientData']['clientId'])) {
                                                                echo $_SESSION['clientData']['clientId'];
                                                            } ?>
                                                        ">
            </fieldset>
        </form>

        <h3>Change Password</h3>
        <p>Passwords must be at least 8 characters, with at least 1 number, 1 capital letter, and 1 special character.</p>
        <p>*Your original password will be changed.</p>

        <form action="/phpmotors/accounts/index.php" method="post">
            <fieldset>
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="StrongP@55word"><br>
                <input type="submit" name="submit" id="regbtn" value="Update Password">
                <input type="hidden" name="action" value="update-password">
                <input type="hidden" name="clientId" value="<?php if (isset($_SESSION['clientData']['clientId'])) {
                                                                echo $_SESSION['clientData']['clientId'];
                                                            } ?>
                                                        ">
            </fieldset>
        </form>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>
</body>

</html>