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
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
               }
        ?>

        <form action="/phpmotors/accounts/" method="post">
            <label for="email-input">Email Address:</label>
            <input type="email" id="email-input" name="clientEmail" placeholder="email address" required <?php if (isset($clientEmail)) {
                                                                                                                echo "value='$clientEmail'";
                                                                                                            } ?>/>
            <label for="password-input">Password:</label>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> 
            <input type="password" id="password-input" name="clientPassword" placeholder="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required/>
            <button type="submit">Login</button>

            <input type="hidden" name="action" value="Login">
        </form>
        <h2>No account?<a class="login-signup-link" href="/phpmotors/accounts?action=registration">Sign-up</a></h2>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/components/footer.php'
    ?>
</body>

</html>