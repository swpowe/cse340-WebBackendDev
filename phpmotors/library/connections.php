<?php
// Proxy connections to phpmotors database
function phpmotorsConnect()
{
    $server = 'localhost'; //PASS
    // $server = 'localhostss'; //FAIL
    $dbname = 'phpmotors';
    $username = 'iClient';
    // $password = 'Oge3Kl2T!zfEQ6b7'; //music-studio
    $password = 'hh/aKmOQ(RGrns9H'; //chester

    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        // if (is_object($link)) {
        //     echo 'It Worked!';
        // }
        return $link;
    } catch (PDOException $e) {
        header('Location: view/error500.php');
        exit;
    }
}

// phpmotorsConnect(); // testing only
