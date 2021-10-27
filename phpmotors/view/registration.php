<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Create new account.</title>
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
        if (isset($message)) {
            echo $message;
        }
        ?>

        <form action="/phpmotors/accounts/index.php" method="post">
            <label for="firstName-input">First Name:</label>
            <input type="text" id="firstName-input" name="clientFirstname" placeholder="First Name" required />
            <label for="lastName-input">Last Name:</label>
            <input type="text" id="lastName-input" name="clientLastname" placeholder="lastName" required />
            <label for="email-input">Email Address:</label>
            <input type="email" id="email-input" name="clientEmail" placeholder="email address" required/>
            <label for="password-input">Password:</label>
            <input type="password" id="password-input" name="clientPassword" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required/>
            <button id="regbtn" type="submit" name="submit">Sign-up</button>

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="register">
        </form>
        <h2>Already have an account?<a class="login-signup-link" href="/phpmotors/accounts?action=login">Login here</a></h2>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>