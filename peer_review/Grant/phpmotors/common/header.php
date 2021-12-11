<?php

$header = "<img id='logo' src='/phpmotors/images/site/logo.png' alt='PHP Motors Logo'>";
$header .= "<h3><span>";
if (isset($_SESSION['loggedin'])) {
    $header .= "<a href='/phpmotors/accounts/'>Welcome, ".$_SESSION['clientData']['clientFirstname']."</a>  |  <a href='/phpmotors/accounts?action=logout'>Log Out</a></span></h3>";

}
else {
    $header .= "<a href='/phpmotors/accounts?action=login-page'>My Account</a></span></h3>";
}