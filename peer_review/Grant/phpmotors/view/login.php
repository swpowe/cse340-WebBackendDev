<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHP Motors Home</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
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
        <h1>Login</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>

        <form action="/phpmotors/accounts/" method="post">
            <label for="email">Email Address:</label><br>
            <input type="email" id="email" name="clientEmail" <?php if (isset($clientEmail)) {
                                                                    echo "value='$clientEmail'";
                                                                } ?> required placeholder="JohnSmith@email.com"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="StrongP@55word"><br>
            <span>Passwords must be at least 8 characters, with at least 1 number, 1 capital letter, and 1 special character.</span><br>
            <input type="submit" value="Login">
            <input type="hidden" name="action" value="Login">

        </form>
        <p><a href="/phpmotors/accounts?action=register">Don't have an account? Sign up here.</a></p>

    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. </br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.</br>
            Last Updated: </p>
    </footer>
</body>

</html>