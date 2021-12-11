<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Login Page</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/alt-views.css" type="text/css" rel="stylesheet" media="screen">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<meta name="description" content="template document">
</head>
<body>
    <div id="wrapper">

<!-- Header -->
<header>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php' ?>
</header>

<!-- Nav Bar -->
<nav>
<!-- < ?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/nav.php' ?>  NOTE: remove space before the '?' to restore php functionality -->
<?php echo $navList; ?> <!-- This should go to index.php and display the navBar from that variable -->
</nav>
<!-- Main Content -->
<main>
    <h1 id="loginTitle">Sign in</h1>
    <!-- PHP code to display errors, per assignment instructions -->
    <div class="messageDiv">
    <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];} ?>
    </div>
        <form name="loginform" action="/phpmotors/accounts/index.php" method="post">     <!-- this action might be "get" -->
                <div class="form-box">
                    <label for="clientEmail">E-Mail
                        <input type="email" id="clientEmail" name="clientEmail" 
                        <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  
                        ?> required>
                    </label>
                </div><br>
                <p id="passwordWarning">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</p>
                <div class="form-box">
                    <label for="password">Password
                        <input type="password" id="password" name="clientPassword" required
                        pattern ="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    </label>
                </div>
    <input type="submit" name="submit" id="sign-in-button" value="Sign-in"> <!-- These 2 inputs must be inside the <form> or they will break -->
    <!-- This hidden input has Login with a capital "L", to differenciate the original login view from the Login command in the controller -->
    <input type="hidden" name="action" value="Login">
</form>

    <br>
    <a href="http://localhost/phpmotors/accounts/index.php?action=register-page" title="Register an account with PHP Motors!" id="newAccount">Not a member yet?</a>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>
<?php unset($_SESSION['message']); ?>