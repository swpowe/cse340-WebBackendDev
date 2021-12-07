<?php
// Make sure the user is logged in AND is an Admin; redirect to home if not
if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 3) {
    header('Location: /phpmotors');
}
if (isset($_SESSION['message'])) {
    echo 'problem';
    $message = $_SESSION['message'];
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
$details = getInvItemInfo(1); //!! hard coded?? Needed??
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
        <section class="reviews">
            <hr>
            <p><?php $details?> </p>
            <h2>Customer Reviews</h2>
            <h2>Review the <car-name></h2>
            <div class="review">
                <form action="" class="review-form">
                <label for="username">
                    Screen Name:
                    <input id="username" type="text" value="USERNAME" readonly>
                </label>
                <label for="review-text">
                    Review:
                    <input type="text" id="review-text">
                </label>
                <button type="submit">Submit Review</button>
                </form>

                <p>Be the first to write a review.</p>
            </div>
        </section>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
    <!-- <script src="../js/inventory.js"></script> -->
</body>

</html>
<?php unset($_SESSION['message']); ?>