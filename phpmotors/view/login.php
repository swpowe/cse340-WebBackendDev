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
    require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/components/header.php'
    ?>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <form action="login_form.php" method="post">
            <label for="email-input">Email Address:</label>
            <input type="text" id="email-input" name="email-input" placeholder="email address" />
            <label for="password-input">Password:</label>
            <input type="password" id="password-input" name="password-input" placeholder="password" />
            <button type="submit">Login</button>
        </form>
        <h2>No account?<a class="login-signup-link" href="/phpmotors/accounts?action=registration">Sign-up</a></h2>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/components/footer.php'
    ?>
</body>

</html>