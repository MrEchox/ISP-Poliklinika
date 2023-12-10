<?php

include 'database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user credentials
    $login_result = $database->confirmUserPass($email, $password);

    // Check the result of login attempt
    if ($login_result == 0) {
        // Successful login, redirect to a welcome page or user dashboard
        header("Location: welcome.php");
        exit();
    } else {
        // Failed login, handle errors or redirect to login page with error message
        if ($login_result == 1) {
            $error_message = "User not found.";
        } elseif ($login_result == 2) {
            $error_message = "Incorrect password.";
        }

        // You can choose how to handle errors, for now, let's redirect back to the login page with an error message
        header("Location: login.html?error=" . urlencode($error_message));
        exit();
    }
} else {
    // If the form is not submitted, redirect to the login page
    header("Location: login.html");
    exit();
}
?>
