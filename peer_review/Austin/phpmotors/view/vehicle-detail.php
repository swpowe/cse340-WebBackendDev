<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $vehicleInfo['0']['invMake']." ".$vehicleInfo['0']['invModel']." " ?>| PHP Motors, Inc.</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/classification.css" type="text/css" rel="stylesheet" media="screen">
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
    
    <!-- Display message if one exists -->
    <?php if(isset($message)){
    echo $message; }
    ?>
    <!-- Display vehicle list if one exists -->
    <?php if(isset($vehicleInfoDisplay)){
    echo $vehicleInfoDisplay;
    } ?>

<hr>
<h2>Customer Reviews</h2>

    <!-- What to display if user is logged in --> 
    <?php if(isset($_SESSION['loggedin'])){
    echo "<h3>Review the " . $vehicleInfo['0']['invMake']." ".$vehicleInfo['0']['invModel']." </h3>";
    echo "<div class='messageDiv'>";
    if(isset($_SESSION["message"])) {
        echo $_SESSION["message"];
        unset($_SESSION["message"]);
    }
    echo "</div>";
    echo "<div id='reviewDiv' >";
    echo "<form name='reviewform' action='/phpmotors/reviews/index.php' method='post'>";
    echo "<label for='screenName'>";
    echo "<p> Screen Name: </p>";
    echo "<input type='text' id='screenName' name='screenName' value= '" . strtoupper(substr($_SESSION['clientData']['clientFirstName'],0,1)) . strtoupper(substr($_SESSION['clientData']['clientLastName'],0,1)) . substr($_SESSION['clientData']['clientLastName'],1,14) . "' readonly>";
    echo "</label>";
    echo "<label for='reviewText'>";
    echo "<p> Review: </p>";
    echo "<textarea id='reviewText' name='reviewText'></textarea>";
    echo "</label>";
    echo "<br><input type='submit' name='submit' id='submit-review-button' value='Submit Review'>";
    echo "<input type='hidden' name='action' value='insert-review'>";
    echo "<input type='hidden' name='invId' value='" . $vehicleInfo['0']['invId'] . "'>"; // Passing clientId and invId to the index file here.
    echo "<input type='hidden' name='clientId' value='" . $_SESSION['clientData']['clientId'] . "'>";
    echo "</form>";
    echo "</div>";
    //Display reviews
    if(isset($reviewInfoDisplay)){
        echo $reviewInfoDisplay;
    }
    } else {
    echo "<div id='mustLoginDiv'";
    echo "<p>You must <a href='/phpmotors/accounts/index.php?action=login'>login</a> to write a review.</p>";
    echo "</div>";
    echo "<div id='reviewDiv' >";

    echo "</div>";
    //Display reviews
    if(isset($reviewInfoDisplay)){
        echo $reviewInfoDisplay;
    }
    }?>

</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>