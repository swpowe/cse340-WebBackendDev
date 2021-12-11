<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Update Review</title>
<link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
<link href="/phpmotors/css/medium.css" type="text/css" rel="stylesheet" media="screen">

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
<h1 id="review-update-title">
    <?php if(isset($entireReview['reviewId'])){ 
            foreach($vehicleNameArray as $vehicleInfo){
                echo $vehicleInfo['invMake'] . " " . $vehicleInfo['invModel'] . " Review";
            }
        }?></h1>
        <div class="update-review-body">
        <form name='reviewform' action='/phpmotors/reviews/index.php' method='post'>
            <h2> Review Text:</h2>
            <!-- <p><?php echo"This is the reviewId: " .  $entireReview['reviewId'];?></p> -->
            <label for='reviewText'>
            <textarea id='reviewText' name='reviewText'></textarea>
            </label><br>
            <input type="submit" name="submit" id="modReviewBtn" value="Update Review">
            <input type="hidden" name="action" value="handle-review-update"> <!-- direct update through controller -->
        <!-- pass value into the controller, and then into the model to process the SQL statement -->
        <?php echo "<input type='hidden' name='reviewId' value='" . $entireReview['reviewId'] . "'>";?>
        </form>


        </div>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>