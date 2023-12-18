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

        // Fetch data from the 'vaistas' table using the AsmensKodas
        $sql = "SELECT * FROM vaistas WHERE fk_Pacientas_AsmensKodas = '$asmensKodas'";
        $vaistasResult = $conn->query($sql);
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

<!-- Display vaistas data for the logged-in user -->
<?php
if ($vaistasResult && $vaistasResult->num_rows > 0) {
    echo "<table>"; // Start the table
    echo "<tr>"; // Start a row for table headers
    // Define your table headers here
    echo "<th>Pavadinimas</th>";
    echo "<th>Galiojimo Data</th>";
    echo "<th>Receptinis</th>";
    echo "<th>Pavidalas</th>";
    // echo "<th>Veiksmai</th>"; // Assuming we're removing the actions for now
    echo "</tr>"; // End the row for table headers

    while ($vaistasRow = $vaistasResult->fetch_assoc()) {
        echo "<tr>"; // Start a new row for each record
        echo "<td>" . htmlspecialchars($vaistasRow["Pavadinimas"]) . "</td>";
        echo "<td>" . htmlspecialchars($vaistasRow["GaliojimoData"]) . "</td>";
        echo "<td>" . htmlspecialchars($vaistasRow["Receptinis"]) . "</td>";
        echo "<td>" . htmlspecialchars($vaistasRow["Pavidalas"]) . "</td>";
        // Assuming we're not displaying the change/remove buttons
    }

    echo "</table>"; // End the table
} else {
    echo "No vaistas records found.";
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

