<?php
require '../config.php'; // Include the database configuration file

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["id"])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

function redirectTo($page){
    header("Location: " . $page);
    exit();
}

// Validate and sanitize the input
if (isset($_GET['data']) && isset($_GET['laikas']) && !isset($_GET['confirm'])) {
    $data = $conn->real_escape_string($_GET['data']);
    $laikas = $conn->real_escape_string($_GET['laikas']);

    // Fetch the appointment details from the 'konsultacija' table
    $query = "SELECT * FROM konsultacija WHERE Data = '$data' AND Laikas = '$laikas'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Ištrinti konsultacijas</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .confirmation-box {
                    background-color: #f2f2f2;
                    padding: 20px;
                    border-radius: 5px;
                    text-align: center;
                }
                .btn {
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                .btn:hover {
                    background-color: #45a049;
                }
                .btn-cancel {
                    background-color: #f44336;
                }
            </style>
        </head>
        <body>
        <div class="confirmation-box">
            <h2>Ar tikrai norite ištrinti šį puslapį?</h2>
            <p>Data: <?php echo htmlspecialchars($row["Data"]); ?></p>
            <p>Laikas: <?php echo htmlspecialchars($row["Laikas"]); ?></p>
            <form action="delete_appointment.php" method="get">
                <input type="hidden" name="data" value="<?php echo $data; ?>">
                <input type="hidden" name="laikas" value="<?php echo $laikas; ?>">
                <input type="hidden" name="confirm" value="yes">
                <input type="submit" value="Taip, ištrinti" class="btn">
                <a href="konsultacijos.php" class="btn btn-cancel">Ne</a>
            </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Appointment not found.";
    }
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'yes' && isset($_GET['data']) && isset($_GET['laikas'])) {
    // Confirm deletion
    $data = $conn->real_escape_string($_GET['data']);
    $laikas = $conn->real_escape_string($_GET['laikas']);

    // Delete query for the 'konsultacija' table
    $deleteQuery = "DELETE FROM konsultacija WHERE Data = '$data' AND Laikas = '$laikas'";

    // Execute the query
    if ($conn->query($deleteQuery) === TRUE) {
        // Redirect with a success message
        redirectTo('konsultacijos.php?deletion=success');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
