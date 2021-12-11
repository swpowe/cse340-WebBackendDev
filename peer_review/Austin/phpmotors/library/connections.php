<?php 
/*
* Proxy connection to phpmotors database
*/

function phpmotorsConnect() {
$server = 'localhost';
$dbname = 'phpmotors';
$username = 'iClient';
// $password = '.I3RMt[zfi@w0Xc9';
$password = 'hh/aKmOQ(RGrns9H';
$dsn = "mysql:host=$server;dbname=$dbname";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);


try {
    $link = new PDO($dsn, $username, $password, $options);
    //    if(is_object($link)){
    //        echo 'It Worked!';
    //    }
    return $link;
} catch (PDOException $e) {
    // echo "It didn't work, error code: " . $e->getMessage();
    header('location: /phpmotors/view/500.php');
    exit;
}

} // End of phpmotorsConnect function

phpmotorsConnect(); // Test line, comment or delete when done testing





















?>