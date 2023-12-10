<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendardb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you receive the name and password from a login form via POST method
$userName = $_POST['name'] ?? '';
$userPassword = $_POST['password'] ?? '';

// Query to fetch the user by name
$sql = "SELECT Password FROM Patients WHERE Name = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error in query: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();

    // Verifying the password (assuming the password is stored as a hashed value)
    if (password_verify($userPassword, $row['Password'])) {
        echo "Login successful.";
        // Proceed with login success logic
    } else {
        echo "Invalid password.";
        // Handle invalid password logic
    }
} else {
    echo "No user found with that name.";
    // Handle no user found logic
}

$stmt->close();
$conn->close();
?>
