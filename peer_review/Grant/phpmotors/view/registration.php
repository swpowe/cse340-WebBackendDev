<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account - PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
</head>

<body>
    <header>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php';echo $header; ?>
    </header>

    <nav>
    <?php echo navList(); ?>
    </nav>

    <main>
        <h1>Create Account</h1>
        <?php 
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/accounts/index.php" method="post">
            <label for="firstName">First Name:</label><br>
            <input type="text" id="firstName" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required placeholder="John"><br>
            <label for="lastName">Last Name:</label><br>
            <input type="text" id="lastName" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required placeholder="Smith"><br>
            <label for="email">Email Address:</label><br>
            <input type="email" id="email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required placeholder="JohnSmith@email.com"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="StrongP@55word"><br>
            <span>Passwords must be at least 8 characters, with at least 1 number, 1 capital letter, and 1 special character.</span><br>
            <input type="submit" name="submit" id="regbtn" value="Sign Up">
            <input type="hidden" name="action" value="register">
        </form>
        <p><a href="/phpmotors/accounts?action=login-page">Already have an account? Login here.</a></p>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. </br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.</br>
            Last Updated: </p>
    </footer>
</body>

</html>