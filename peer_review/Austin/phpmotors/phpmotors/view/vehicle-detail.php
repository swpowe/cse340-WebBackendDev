<?php
// Make sure the user is logged in AND is an Admin; redirect to home if not
// if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 3) {
//     header('Location: /phpmotors');
// }
// if (isset($_SESSION['message'])) {
//     echo 'problem';
//     $message = $_SESSION['message'];
// }

require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
$details = getInvItemInfo(1); //!! hard coded?? Needed??
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Php Motors Homepage | Vehicles Manager.</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
    <link rel="stylesheet" href="/phpmotors/css/medium.css">
    <link rel="stylesheet" href="/phpmotors/css/large.css">
    <link rel="stylesheet" href="/phpmotors/css/xtra-large.css">

</head>


<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/header.php'
    ?>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <!-- <h1>Vehicle Detail Page</h1> -->
        <?php if (isset($vehicleDetails)) {
            echo $vehicleDetails;
        } ?>
        <!--!! Build out function that builds reviews -->
        <!-- !! move this into the function that builds the view? -->
        <!-- <section class="reviews">
            <hr>

            <h2>Customer Reviews</h2>
            
            <?php 
                // echo $_SESSION['vehicleData']['invId'];
                // echo buildAddReviewView(); 
                // echo buildPreviewsReviews();
            ?>
        </section> -->
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
    <!-- <script src="../js/inventory.js"></script> -->
</body>

</html>
<?php unset($_SESSION['message']); ?>