<?php
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/reviews-model.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Review | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css">
</head>

<body>
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php';
        echo $header; ?>
    </header>

    <nav>
        <?php echo navList(); ?>
    </nav>

    <main>
        <h1>Edit your review</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/reviews/index.php" method="post">
            <fieldset>
                <textarea rows="5" cols="70" name="reviewText" id="reviewText" ><?php echo $reviewInfo['reviewText']; ?></textarea><br>
                <input type="submit" name="submit" value="Update Review">
                <input type="hidden" name="action" value="updateReview">
                <input type="hidden" name="reviewId" value="<?php echo $reviewInfo['reviewId']; ?>">
            </fieldset>
        </form>
    </main>

    <footer>
        <hr>
        <p>&copy; PHP Motors, All rights reserved. <br>
            All Images used are believed to be in "Fair Use". Please Notify the author if any are not and they will be removed.<br>
            Last Updated: </p>
    </footer>
</body>

</html>