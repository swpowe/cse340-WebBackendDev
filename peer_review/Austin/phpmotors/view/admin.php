<?php if(!isset($_SESSION['loggedin'])){ // If you're not logged in, you'll be sent to the homepage
        header('Location: /phpmotors/');
 }?><!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Client Admin</title>
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
<div class="messageDiv">
    <?php if(isset($_SESSION["message"])) {
             echo $_SESSION["message"];
             unset($_SESSION["message"]);
    } ?>
    </div>
<?php if(isset($_SESSION['loggedin'])){
echo "<h1 class='loggedinFullname'>";
echo $_SESSION['clientData']['clientFirstName'];
echo " ";
echo $_SESSION['clientData']['clientLastName'];
echo "</h1>";
echo "<p class='loggedInMessage'> You are logged in. </p>";

echo "<p class='loggedInInfo'> First name: ";
echo $_SESSION['clientData']['clientFirstName'];
echo "</p>";

echo "<p class='loggedInInfo'> Last name: ";
echo $_SESSION['clientData']['clientLastName'];
echo "</p>";

echo "<p class='loggedInInfo'> Email: ";
echo $_SESSION['clientData']['clientEmail'];
echo "</p>";
} ?>
<h2 id="accountMan"> Account Management</h2>
<p id="accountManSub"> Use this link to update account information </p>
<!-- Check the value in the name/value pair below... It might not even be necessary -->
<a href='http://localhost/phpmotors/accounts/index.php?action=accountInfo' id='accountInfoLink'>Update Account Information</a><br><br>
<input type="hidden" name="action" value="admin">
<?php
if(($_SESSION['clientData']['clientLevel']) > 1){
echo "<h2 class='adminPrivilegeTitle'> Inventory Management </h2>";
echo "<p class='loggedInInfo'> Use this link to manage the inventory. </p><br>";
echo "<a href='http://localhost/phpmotors/vehicles' id='vehicleManageLink'>Vehicle Management</a><br><br>";
}
if(isset($_SESSION['loggedin'])){
$arrayOfReviews = getReviewByClient($_SESSION['clientData']['clientId']);
echo "<div class='admin-view-reviews'>";
echo "<h2> Manage Your Product Reviews </h2>";
echo "<ul>";
//Go through each review
foreach ($arrayOfReviews as $singleReview){
//echo $singleReview['reviewId'] . "   " . $singleReview['reviewText'] . "<br><br>";
$vehicleThatWasReviewed = getVehicleByInvId($singleReview['invId']);
//Go through vehicle info array, and pull out the name of it.
foreach ($vehicleThatWasReviewed as $vehicle){
echo "<li>" . $vehicle['invMake'] . " " . $vehicle['invModel'] . " (Reviewed on " . date("d, F Y", (strtotime($singleReview['reviewDate']))) . "): ";
echo "<a href='/phpmotors/reviews/?action=edit-review&reviewId=" . urlencode($singleReview['reviewId']) ."'> Edit </a> | "
    . "<a href='/phpmotors/reviews/?action=confirm-review-delete&reviewId=". urlencode($singleReview['reviewId']) ."'> Delete </a>"
."</li>";

}
//print_r($singleReview);
echo "<br>";
}
echo "</ul>";
echo "</div>";
}


  ?>

</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>
<?php unset($_SESSION['message']); ?>