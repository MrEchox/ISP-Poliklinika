<?php
require '../config.php'; // Include the database configuration file

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the session variable for user ID is set and not empty
if (!empty($_SESSION["id"])) {
    $sessionID = $_SESSION["id"];

    // Fetch user's AsmensKodas from the pacientas table using the session ID
    $pacientasQuery = "SELECT AsmensKodas FROM pacientas WHERE fk_Naudotojas_EPastas = '$sessionID'";
    $pacientasResult = $conn->query($pacientasQuery);

    if ($pacientasResult && $pacientasResult->num_rows > 0) {
        $pacientasRow = $pacientasResult->fetch_assoc();
        $asmensKodas = $pacientasRow["AsmensKodas"];

        // Fetch data from the 'tyrimas' table using the AsmensKodas
        $sql = "SELECT * FROM tyrimas WHERE `fk_Pacientas-AsmensKodas` = '$asmensKodas'";
        $tyrimasResult = $conn->query($sql);
    } else {
        echo "Patient not found.";
        exit();
    }
} else {
    // Redirect to login page if the session ID is not set
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registravimasis</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="pacientas.css">
</head>
<body>
<!-- NAVBAR -->
<div class="navbar">
    <a class="logo"><img src="../LOGO.png" alt="Logo" width="44" height="32"></a>
    <a class="right" href="paciento_profilils.php">Grįžti</a>
</div>

<!-- Display tyrimas data for the logged-in user -->
<?php
if ($tyrimasResult && $tyrimasResult->num_rows > 0) {
    echo "<table>"; // Start the table
    echo "<tr>"; // Start a row for table headers
    // Define your table headers here
    echo "<th>Pavadinimas</th>";
    echo "<th>Analize</th>";
    echo "<th>Svarba</th>";
    echo "<th>Kaina</th>";
    echo "<th>Busena</th>";
    // echo "<th>Veiksmai</th>"; // Assuming we're removing the actions for now
    echo "</tr>"; // End the row for table headers

    while ($tyrimasRow = $tyrimasResult->fetch_assoc()) {
        echo "<tr>"; // Start a new row for each record
        echo "<td>" . htmlspecialchars($tyrimasRow["Pavadinimas"]) . "</td>";
        echo "<td>" . htmlspecialchars($tyrimasRow["Analize"]) . "</td>";
        echo "<td>" . htmlspecialchars($tyrimasRow["Svarba"]) . "</td>";
        echo "<td>" . htmlspecialchars($tyrimasRow["Kaina"]) . "</td>";
        echo "<td>" . htmlspecialchars($tyrimasRow["Busena"]) . "</td>";
        // Assuming we're not displaying the change/remove buttons
    }

    echo "</table>"; // End the table
} else {
    echo "No tyrimas records found.";
}
?>
<!-- Additional HTML content and links -->
<a href="paciento_profilils.php">
    <input type="button" value="Grysti" class="buttonAD">
</a>


<footer>
    <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
</footer>
<br>
</body>
</html>