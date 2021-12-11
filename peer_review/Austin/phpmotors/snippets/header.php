<div id="top-header">
<img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo" id="logo">
<!-- PHP block to check for existing cookie. If one exists, a custom greeting is generated -->
<?php if(isset($_SESSION['loggedin'])){
 echo "<a id='welcomeMsg' href='http://localhost/phpmotors/accounts/index.php?action=clientAdmin'> Welcome ";   
 echo $_SESSION['clientData']['clientFirstName'];
 echo "!</a>";
} ?>

<?php if(isset($_SESSION['loggedin'])){
 echo "<div id='loggedInDiv'>";
 echo "<p>";
 echo $_SESSION['clientData']['clientFirstName']; 
 echo "| </p>";
 echo "<a href='http://localhost/phpmotors/accounts/index.php?action=logout' title='Log out of your account' class='logoutButton'>Logout</a>";
 echo "</div>";
} else {
 echo "<a href='http://localhost/phpmotors/accounts/index.php?action=login' title='Login to or Register an account with PHP Motors!' class='acc'>My Account</a>";
}
?>
</div>