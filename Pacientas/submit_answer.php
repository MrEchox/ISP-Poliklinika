<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendarDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $conn->real_escape_string($_POST['name']);
$answer = $conn->real_escape_string($_POST['answer']);
$selected_datetime = $conn->real_escape_string($_POST['selected_datetime']);

// Prepare an insert statement to avoid SQL Injection
$stmt = $conn->prepare("INSERT INTO answers (name, answer, selected_datetime) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $answer, $selected_datetime);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: success.html"); // Redirect to success.html
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
