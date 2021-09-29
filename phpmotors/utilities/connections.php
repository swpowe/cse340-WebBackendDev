<?php
// Proxy connections to phpmotors database

function phpmotorsConnect() {
$server = 'mysql';
$dbname = 'tutorial';
$username = 'tutorial';
$password = 'secret';

$dsn = "mysql:host=$server:3306;dbname=$dbname";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try{
    $link = new PDO($dsn, $username, $password, $options);
    if(is_object($link)){
        echo 'It Worked!';
    }
}catch(PDOException $e) {
    echo "It didn't work, error: " .$e->getMessage();
}
}

phpmotorsConnect();
