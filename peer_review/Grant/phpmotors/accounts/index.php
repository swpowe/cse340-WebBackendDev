<?php
//This is the Accounts controller

session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../library/functions.php';

$navList = navList();



$clientFirstname = filter_input(INPUT_POST, 'clientFirstname');
$clientLastname = filter_input(INPUT_POST, 'clientLastname');
$clientEmail = filter_input(INPUT_POST, 'clientEmail');
$clientPassword = filter_input(INPUT_POST, 'clientPassword');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'register':

        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = uniqueEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            exit;
        }

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            // include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            header('Location: /phpmotors/accounts/?action=login-page');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
            exit;
        }
        break;
    case 'login-page':
        $clientEmail = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/accounts?action=login-page';
        break;
    case 'Login':

        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientEmail) || empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/accounts?action=login-page';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        include '../view/admin.php';
        exit;
        break;
    case 'logout':
        session_unset();
        session_destroy();
        header('Location: /phpmotors/');
        break;
    case 'update-view':
        $clientId = filter_input(INPUT_GET, 'clientId', FILTER_VALIDATE_INT);
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
        break;
    case 'update-client':

        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $newClientEmail = trim(filter_input(INPUT_POST, 'newClientEmail', FILTER_SANITIZE_EMAIL));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        $clientEmail = checkEmail($clientEmail);

        $existingEmail = uniqueEmail($clientEmail);



        // Check for existing email address in the database
        if ($clientEmail = $newClientEmail) {
            if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
                $message = '<p>Please provide information for all empty form fields.</p>';
                include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
                exit;
            }
    
            $updateClient = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);
    
            if (!$updateClient) {
                $message = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
                include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
                exit;
            }
            $message = "<p>Thank you $clientFirstname. Your information has been updated.</p>";
            $_SESSION['message'] = $message;        
            $clientData = getClientInfo($clientId);
            $_SESSION['clientData'] = $clientData;
    
            header('Location: /phpmotors/accounts/');
    
            exit;
        }
        elseif ($existingEmail) {
            $message = '<p>That email is already in use. Please use a different email.</p>';
            $_SESSION['message'] = $message;        
            include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/view/client-update.php';
            exit;
        }


        break;

    case 'update-password':

        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
        $checkPassword = checkPassword($clientPassword);
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if (empty($checkPassword)) {
            $message = '<p>Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $updatePassword = updatePassword($hashedPassword, $clientId);

        if ($updatePassword) {
            $message = "<p>Success! Your password has been changed</p>";
            $_SESSION['message'] = $message;
            // include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p>Sorry, password change failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
            exit;
        }
        break;


    default:
        include $_SERVER["DOCUMENT_ROOT"] . '/phpmotors/view/admin.php';
        break;
}
