<?php
// Proxy connections to phpmotors database

function phpmotorsConnect()
{
<<<<<<< HEAD
    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'iClient';
    // $password = 'Oge3Kl2T!zfEQ6b7'; //music-studio
    $password = 'hh/aKmOQ(RGrns9H'; //chester

    $dsn = "mysql:host=$server;dbname=$dbname";
=======
    $server = 'mysql-';
    $dbname = 'tutorial';
    $username = 'tutorial';
    $password = 'secret';

    $dsn = "mysql:host=$server:3306;dbname=$dbname";
>>>>>>> b6d6de15ff045cb132e3e2cd5e5d6b601ff5a2fb
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        // if (is_object($link)) {
        //     echo 'It Worked!';
        // }
        return $link;
    } catch (PDOException $e) {
<<<<<<< HEAD
        header('Location: /view/error500f.php');
=======
        // echo "It didn't work, error: " .$e->getMessage();
        require '../view/error500.php';
        // header('Location: .../view/error500.php');
        // require '../view/error500.php';
>>>>>>> b6d6de15ff045cb132e3e2cd5e5d6b601ff5a2fb
        exit;
    }
}

// phpmotorsConnect(); // testing only
