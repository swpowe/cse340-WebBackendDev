<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Login.</title>
    <link rel="stylesheet" href="/phpmotors/css/main.css">

</head>


<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/components/header.php'
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
            <label for="email-input">Email Address:</label>
            <input type="email" id="email-input" name="email-input" placeholder="email address" required/>
            <label for="password-input">Password:</label>
            <p>*password must contain ....</p>
            <input type="password" id="password-input" name="password-input" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required/>
            <button type="submit">Login</button>
        </form>
        <h2>No account?<a class="login-signup-link" href="/phpmotors/accounts?action=registration">Sign-up</a></h2>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/components/footer.php'
    ?>
</body>

</html>