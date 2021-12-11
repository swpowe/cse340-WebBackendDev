<?php
/*************************************** 
 * Main Controller for PHP Motors site
 **************************************/ 

// create or access a session
session_start();
// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the functions file
require_once 'library/functions.php';


// Call getClassification function and assign value to variable
$classifications = getClassifications();

// Build a navigation bar using the buildNavbar function
$navList = buildNavbar($classifications);

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
 }
 
// Logic for traffic direction
$action = filter_input(INPUT_GET, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_POST, 'action');
 }

 switch ($action){
 case 'template':
  include 'view/template.php';
  break;
 
 default:
  include 'view/home.php';
  break;
}
// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
 }