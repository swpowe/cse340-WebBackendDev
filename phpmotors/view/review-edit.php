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
        <h1>edit review page</h1>
        <?php
            $username = substr($_SESSION['clientData']['clientFirstname'], 0, 1)
            .strtolower($_SESSION['clientData']['clientLastname']);

            

           if (isset($reviewDetails)) {
                // echo '<h1>' .$reviewDetails[0]["reviewText"]. '</h1>';

                $timestamp = date('d M, Y', strtotime($reviewDetails[0]["reviewDate"]));

                $html = "<section class='review-edit-form'>";
                $html .= "<h1>" .$reviewDetails[0]['invMake']." " .$reviewDetails[0]['invModel']." Review</h1>";
                $html .= "<h2>Reviewed on " .$timestamp. "</h2>";
                $html .= "<form action='/phpmotors/reviews?action=review-update' method='POST'>"; //!! update to hit index update
                $html .= "<label for='review-text-box'>Review Text</label>";
                $html .= "<input type='text' id='review-text-box' value='" .$reviewDetails[0]['reviewText']. "'></input>";
                $html .= "<button type='submit'>Update</button>";
                $html .= "</form>";   
                $html .= "</section>";   
                echo $html;
                
            }else {
                echo '<h1>No details? </h1>';
            }
        // echo '<h2>Review Id Passed: '.$reviewId .'<h2>';
        ?>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/components/footer.php'
    ?>
</body>

</html>