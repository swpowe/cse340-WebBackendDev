<?php
// This is the main controller

// Create or Access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the functions library
require_once 'library/functions.php';
//!! Get the PHP Motors model for use as needed
require_once 'model/main-model.php';



//!! Get the array of classifications
$classifications = getClassifications();

// var_dump($classifications); // Testing Only. Returns DB object data
// 	exit;

//!! Build a navigation bar using the $classifications array
// $navList = '<ul>';
// $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//  $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
// }
// $navList .= '</ul>';

// echo $navList; // Testing Only
// exit;

$navList = dynamicNav($classifications);


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

// Inject name via cookie info
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    case 'login': // TESTING ONLY
        include 'view/login.php';
        break;

    default:
        include 'view/home.php';
}
