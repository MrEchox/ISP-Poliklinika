<?php
require '../config.php'; // Include the database configuration file

// Check if the session variable for user ID is set and not empty
if (!empty($_SESSION["id"])) {
    $sessionID = $_SESSION["id"];

    // Fetch user's AsmensKodas from pacientas table using the session ID
    $pacientasQuery = "SELECT p.AsmensKodas FROM pacientas p INNER JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas WHERE n.EPastas = '$sessionID'";
    $pacientasResult = $conn->query($pacientasQuery);

    if ($pacientasResult && $pacientasResult->num_rows > 0) {
        $pacientasRow = $pacientasResult->fetch_assoc();
        $asmensKodas = $pacientasRow["AsmensKodas"];

        // Fetch data from 'siuntimas' table using the AsmensKodas
        $sql = "SELECT * FROM siuntimas WHERE `fk_Pacientas-AsmensKodas` = $asmensKodas";
        $siuntimasResult = $conn->query($sql);
    } else {
        echo "Patient not found.";
        exit();
    }
}
else {
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

<!-- Display siuntimas data for the logged-in user -->
<?php
if ($siuntimasResult && $siuntimasResult->num_rows > 0) {
    echo "<table>"; // Start the table
    echo "<tr>"; // Start a row for table headers
    // Define your table headers here
    echo "<th>Data</th>";
    echo "<th>Klinikine Diagnoze</th>";
    echo "<th>Skyrius</th>";
    echo "<th>Pagrindine Diagnoze</th>";
    echo "</tr>"; // End the row for table headers

    while ($siuntimasRow = $siuntimasResult->fetch_assoc()) {
        echo "<tr>"; // Start a new row for each record
        echo "<td>" . htmlspecialchars($siuntimasRow["Data"]) . "</td>";
        echo "<td>" . htmlspecialchars($siuntimasRow["KlinikineDiagnoze"]) . "</td>";
        echo "<td>" . htmlspecialchars($siuntimasRow["Skyrius"]) . "</td>";
        echo "<td>" . htmlspecialchars($siuntimasRow["PagrindineDiagnoze"]) . "</td>";
    }

    echo "</table>"; // End the table
} else {
    echo "No siuntimas records found.";
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
