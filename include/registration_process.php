<?php

include 'database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    // Validate user inputs (you may add more validation as needed)

    // Check if passwords match
    if ($password != $confirm_password) {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=" . urlencode("Slaptažodžiai nesutampa."));
        exit();
    }

    // Check if the email is already taken
    if ($database->emailTaken($email)) {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=" . urlencode("Toks el. paštas jau užimtas."));
        exit();
    }

    // Add new user to the database
    $registration_result = $database->addNewUser($first_name, $last_name, $email, $phone, $password);

    // Check the result of registration attempt
    if ($registration_result) {
        // Successful registration, redirect to a welcome page or user dashboard
        header("Location: home.html");
        exit();
    } else {
        // Failed registration, handle errors or redirect to registration page with error message
        // You can customize this based on your needs
        header("Location: register.html?error=" . urlencode("Įvyko klaida."));
        exit();
    }
} else {
    // If the form is not submitted, redirect to the registration page
    header("Location: register.html");
    exit();
}
?>
