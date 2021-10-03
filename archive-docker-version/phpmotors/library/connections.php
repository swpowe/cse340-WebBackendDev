<?php
// Proxy connections to phpmotors database

function phpmotorsConnect()
{
    $server = 'mysql-';
    $dbname = 'tutorial';
    $username = 'tutorial';
    $password = 'secret';

    $dsn = "mysql:host=$server:3306;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $options);
        // if (is_object($link)) {
        //     echo 'It Worked!';
        // }
        return $link;
    } catch (PDOException $e) {
        // echo "It didn't work, error: " .$e->getMessage();
        require '../view/error500.php';
        // header('Location: .../view/error500.php');
        // require '../view/error500.php';
        exit;
    }
}

// phpmotorsConnect(); // testing only
