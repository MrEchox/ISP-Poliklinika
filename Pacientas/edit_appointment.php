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

$updated = false;
$errorMessage = '';
$appointmentDetails = null;

$data = isset($_GET['data']) ? $conn->real_escape_string($_GET['data']) : '';
$laikas = isset($_GET['laikas']) ? $conn->real_escape_string($_GET['laikas']) : '';

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $data && $laikas) {
    $newDate = $conn->real_escape_string($_POST['newDate']);
    $newTime = $conn->real_escape_string($_POST['newTime']);

    // Check if new data and time are different from the current data and time
    if ($newDate !== $data || $newTime !== $laikas) {
        // Update query for the 'konsultacija' table
        $updateQuery = "UPDATE konsultacija SET Data = ?, Laikas = ? WHERE Data = ? AND Laikas = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssss", $newDate, $newTime, $data, $laikas);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to konsultacijos.php with a success message
            header("Location: konsultacijos.php?edit=success");
            exit();
        } else {
            // If the update failed, set an error message
            $errorMessage = "Error updating record: " . $conn->error;
        }
        $stmt->close();
    } else {
        // If the data is the same as before, set an error message
        $errorMessage = "No changes were made to the appointment.";
    }
}

// Fetch the current details of the consultation including doctor's email
if (!$errorMessage && $data && $laikas) {
    $query = "SELECT konsultacija.Data, konsultacija.Laikas, konsultacija.fk_Pacientas_AsmensKodas, gydytojas.fk_Naudotojas_EPastas 
              FROM konsultacija 
              INNER JOIN gydytojas ON konsultacija.fk_Gydytojas_id = gydytojas.id 
              WHERE konsultacija.Data = ? AND konsultacija.Laikas = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $data, $laikas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $appointmentDetails = $result->fetch_assoc();
    } else {
        $errorMessage = "Appointment not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keisti konsultaciją</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .content {
            background-color: #fff;
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .appointment-details {
            background-color: #e7e7e7;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="time"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            background-color: #5c6bc0;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #3f51b5;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #5c6bc0;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #3f51b5;
        }

        .error-message {
            color: #d32f2f;
            background-color: #fdecea;
            border-left: 4px solid #d32f2f;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<!-- NAVBAR -->
<div class="navbar">
    <a class="logo"><img src="../LOGO.png" alt="Logo" width="44" height="32"></a>
    <a class="right" href="konsultacijos.php">Grįžti</a>
</div>
<div class="content">
    <h2>Keisti konsultaciją</h2>

    <?php if ($errorMessage): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if (isset($appointmentDetails)): ?>
        <div class="appointment-details">
            <h3>Current Appointment Details:</h3>
            <p>Date: <?php echo htmlspecialchars($appointmentDetails["Data"]); ?></p>
            <p>Time: <?php echo htmlspecialchars($appointmentDetails["Laikas"]); ?></p>
        </div>
    <?php endif; ?>

    <form action="edit_appointment.php?data=<?php echo $data; ?>&laikas=<?php echo $laikas; ?>" method="post">
        <input type="hidden" name="currentData" value="<?php echo $data; ?>">
        <input type="hidden" name="currentLaikas" value="<?php echo $laikas; ?>">
        <label for="newDate">Naujas Laikas</label>
        <input type="date" name="newDate" value="<?php echo $data; ?>" required>
        <label for="newTime">Naujos valandos</label>
        <input type="time" name="newTime" value="<?php echo $laikas; ?>" required>
        <input type="submit" value="Update" class="button">
    </form>
</div>
</body>
</html>