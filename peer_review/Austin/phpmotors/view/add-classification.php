<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Motors | Add Classification</title>
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
    <h1 id="classMenuTitle">Add Classification</h1>
    <!-- Display errors sent from vehicles controller --> 
    <div class="messageDiv">
    <?php
if (isset($message)) {
 echo $message;
}
?>
</div>
<form name="addClassForm" action="/phpmotors/vehicles/index.php" method="post">
                <div class="form-box">
                    <label for="class">Classification Name
                        <input type="text" id="class" maxlength="30" name="classificationName" required>
                    </label>
                </div><br>
<input type="submit" name="submit" id="addClassBtn" value="Add Classification">
<input type="hidden" name="action" value="addClassification">
</form>
</main>

<!-- Footer -->
<footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php' ?>
</footer>
</div> <!-- End of Wrapper -->
</body>
</html>