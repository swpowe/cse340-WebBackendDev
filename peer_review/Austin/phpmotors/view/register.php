<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Registration Page</title>
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
<?php
if (isset($message)) {
 echo $message;
}
?>
</div>
        <form name="loginform" action="/phpmotors/accounts/index.php" method="post">
        <div class="form-box">
                    <label for="fName">First Name
                        <input type="text" id="fName" name="clientFirstName" 
                        <?php if(isset($clientFirstName)){echo "value='$clientFirstName'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="lName">Last Name
                        <input type="text" id="lName" name="clientLastName" 
                        <?php if(isset($clientLastName)){echo "value='$clientLastName'";}  
                        ?> required>
                    </label>
                </div>
                <div class="form-box">
                    <label for="email">E-Mail
                        <input type="email" id="email" name="clientEmail" 
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

    <input type="submit" name="submit" id="regbtn" value="Register">
    <input type="hidden" name="action" value="register">
</form>

</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>