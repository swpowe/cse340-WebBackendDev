<?php
/******************************* 
 * Accounts Controller
 ******************************/

// create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions file
require_once '../library/functions.php';
// Get reviews model, needed to display reviews onto the admin.php page.
require_once '../model/reviews-model.php';
// Get name of vehicle that review was performed on (admin view)
require_once '../model/vehicles-model.php';


// $clientFirstName = $_SESSION['clientData']['clientFirstName'];
// $clientLastName = $_SESSION['clientData']['clientLastName'];
// $clientLevel = $_SESSION['clientData']['clientLevel'];
// $clientEmail = $_SESSION['clientData']['clientEmail'];



// Call getClassification function and assign value to variable
$classifications = getClassifications();

// var_dump($classifications);
// 	exit;

// Build a navigation bar using the buildNavbar function
$navList = buildNavbar($classifications);


// Logic for traffic direction

$action = filter_input(INPUT_GET, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_POST, 'action');
 }

 switch ($action){
case 'login':
    include '../view/login.php';
    break;
case 'register': // This is coming from the "hidden" input in "register.php"

    // Filter and store the data
    $clientFirstName = trim(filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING));
    $clientLastName = trim(filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

    // Recreate the email variable. The called function will either pass the email on, or return NULL if invalid.
    // NOTE: this lines runs from "right to left", so the original $clientEmail value is intact, then overwritten.
    $clientEmail = checkEmail($clientEmail);

    // Run server-side password check on password with external function. This code is also execute from "right to left."
    $checkPassword = checkPassword($clientPassword);

    // check for existing email
    $existingEmail = checkExistingEmail($clientEmail);

    // Handle existing email during registration
    if($existingEmail){ // If this comes back as true, that means a matching email address was found (duplicate)
     $message = '<p>That email address already exists. Do you want to login instead?</p>';
     include '../view/login.php';
     exit;
    }

    // Check for missing data
    if(empty($clientFirstName) || empty($clientLastName) || empty($clientEmail) || empty($checkPassword)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        include '../view/register.php';
        exit; 
    }

    //Hashing the password to encrypt senstive data. Built in function.
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model (we send the hashed password, not the "client" password)
        $regOutcome = regClient($clientFirstName, $clientLastName, $clientEmail, $hashedPassword);

    // Check and report the result
    if($regOutcome === 1){
        setcookie('firstname', $clientFirstName, strtotime('+1 year'), '/'); // Creation of site cookie for user's browser

        $_SESSION['message'] = "Thanks for registering $clientFirstName. Please use your email and password to login.";
        header('Location: /phpmotors/accounts/?action=login');
        exit;
    } else { // If registration failed, or regOutcome != 1
        $message = "<p>Sorry $clientFirstName, but the registration failed. Please try again.</p>";
        include '../view/register.php';
        exit;
    }
        break;

case 'Login': // This is coming from the hidden input on "login.php" to log users into their accounts

    //Store and Filter the two inputs from the user login
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));

    //Same as before, function to check email.
    $clientEmail = checkEmail($clientEmail);

    //Same as before, function to check password complexity requirements.
    $checkPassword = checkPassword($clientPassword);

    //Check for empty fields
    if(empty($clientEmail) || empty($checkPassword)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        include '../view/login.php';
        exit; 
       }
    
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    if (empty($clientData)){
        $message = '<p>Please check your credentials and try again.</p>';
        $_SESSION['message'] = $message;
        include '../view/login.php';
        exit;
    }
    // Compare the password just submitted against
    // the hashed password for the matching client. This function is built into PHP, it should work on its own.
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if(!$hashCheck) {
    $message = '<p>Please check your credentials and try again.</p>';
    $_SESSION['message'] = $message;
    include '../view/login.php';
    exit;
    }
    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array. This function is also built into PHP.
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    include '../view/admin.php';
    exit;

    break;
case 'register-page':
    include '../view/register.php';
    break;
case 'clientAdmin':
    include '../view/admin.php';
    break;
case 'logout':
    unset($_SESSION["clientData"]); // Make sure this is proper syntax to unset the session.
    session_destroy();
    header('Location: /phpmotors/');
    break;

    /* FIGURE OUT THE CASE STATEMENT BELOW */

case 'updateAccount':
    // Filter and store the data
    $clientFirstName = trim(filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING));
    $clientLastName = trim(filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    //$clientData = getClient($clientEmail);
    $clientId = $_SESSION['clientData']['clientId'];
    // Recreate the email variable. The called function will either pass the email on, or return NULL if invalid.
    // NOTE: this lines runs from "right to left", so the original $clientEmail value is intact, then overwritten.
    $clientEmail = checkEmail($clientEmail);

    $existingEmail = checkEmailUpdate($clientEmail, $clientId);
    if ($existingEmail) {
        $message = "<p class='messageDiv'>That email already exists. Please enter a new email address.</p>";
        $_SESSION['message'] = $message;
        include '../view/manage-account.php';
        exit;
    } else {
        // Check for missing data 
        if(empty($clientFirstName) || empty($clientLastName) || empty($clientEmail)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            $_SESSION['message'] = $message;
            include '../view/manage-account.php';
            exit; 
           }
        // Send data to model
        $updateUser = updateUser($clientId, $clientFirstName, $clientLastName, $clientEmail);
        if ($updateUser) {
            $message = "<p class='messageDiv'>Thank you $clientFirstName, your information has been updated.</p>";
            $_SESSION['message'] = $message;
            //We have to update the session to the new information that is now in the database (as of 2 seconds ago). Otherwise the "$_SESSION" will be outdated until we re-login.
            $_SESSION['clientData']['clientFirstName'] = $clientFirstName;
            $_SESSION['clientData']['clientLastName'] = $clientLastName;
            $_SESSION['clientData']['clientEmail'] = $clientEmail;
            session_write_close();
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p class='messageDiv'>Sorry $clientFirstName, your information could not be updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/manage-account.php';
            exit;
        }

    }

    break;

case 'admin';
 $clientData = getClient($clientEmail);
 include '../view/admin.php';
 break;

case 'updatePassword':
    // Filter and store the data
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
    $clientId =  $_SESSION['clientData']['clientId'];
    $clientFirstName =  $_SESSION['clientData']['clientFirstName'];
    $clientLastName =  $_SESSION['clientData']['clientLastName'];
    $clientEmail =  $_SESSION['clientData']['clientEmail'];
    // Run server-side password check on password with external function. This code is also execute from "right to left."
    $checkPassword = checkPassword($clientPassword);
    //Check for empty password (because they had to have hit the "Update Password" button already in order to get to this point)
    if(empty($checkPassword)){
        $message = '<p>Please enter a new password.</p>';
        $_SESSION['message'] = $message;
        include '../view/manage-account.php';
        exit; 
    }
    //Hashing the password to encrypt senstive data. Built in function.
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    //Send data to model (updatePassword function)
    $passwordUpdateOutcome = updatePassword($clientId, $hashedPassword);
    if ($passwordUpdateOutcome) {
        $message = "<p class='messageDiv'>Thank you $clientFirstName, your information has been updated.</p>";
        $_SESSION['message'] = $message;
        session_write_close();
        header('location: /phpmotors/accounts/');
        exit;
    } else {
        $message = "<p class='messageDiv'>Sorry $clientFirstName, your information could not be updated.</p>";
        $_SESSION['message'] = $message;
        include '../view/manage-account.php';
        exit;
    }
    break;

case 'accountInfo':
    // This needs an "action=name&value" in order to pull up specific account info
    // Or it will be empty inputs every time
    $clientEmail = $_SESSION['clientData']['clientEmail'];
    $clientData = getClient($clientEmail);
        include '../view/manage-account.php';
     //print_r($_SESSION['clientData']);

    break;


default:
//$clientData = getClient($clientEmail);
include '../view/admin.php';
break;
}