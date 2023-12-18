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

        // Fetch data from the 'konsultacija' table using the AsmensKodas
        $sql = "SELECT konsultacija.Data, konsultacija.Laikas, konsultacija.fk_Pacientas_AsmensKodas, gydytojas.fk_Naudotojas_EPastas FROM konsultacija INNER JOIN gydytojas ON konsultacija.fk_Gydytojas_id = gydytojas.id WHERE fk_Pacientas_AsmensKodas = '$asmensKodas'";
        $konsultacijaResult = $conn->query($sql);
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

<!-- Display konsultacija data for the logged-in user -->
<?php
if ($konsultacijaResult && $konsultacijaResult->num_rows > 0) {
    echo "<table>"; // Start the table
    echo "<tr>"; // Start a row for table headers
    echo "<th>Data</th>";
    echo "<th>Laikas</th>";
    echo "<th>Paciento Asmens Kodas</th>";
    echo "<th>Gydytojo El. Paštas</th>";
    echo "<th>Actions</th>";  // Column for buttons
    echo "</tr>"; // End the row for table headers

    while ($konsultacijaRow = $konsultacijaResult->fetch_assoc()) {
        echo "<tr>"; // Start a new row for each record
        echo "<td>" . htmlspecialchars($konsultacijaRow["Data"]) . "</td>";
        echo "<td>" . htmlspecialchars($konsultacijaRow["Laikas"]) . "</td>";
        echo "<td>" . htmlspecialchars($konsultacijaRow["fk_Pacientas_AsmensKodas"]) . "</td>";
        echo "<td>" . htmlspecialchars($konsultacijaRow["fk_Naudotojas_EPastas"]) . "</td>";
        // Add a delete button and an edit button
        echo "<td>";
        echo "<a href='edit_appointment.php?data=" . urlencode($konsultacijaRow["Data"]) . "&laikas=" . urlencode($konsultacijaRow["Laikas"]) . "' class='edit-btn'>Keisti</a> "; // Edit button
        echo "<a href='delete_appointment.php?data=" . urlencode($konsultacijaRow["Data"]) . "&laikas=" . urlencode($konsultacijaRow["Laikas"]) . "' class='delete-btn'>Ištrinti</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>"; // End the table
} else {
    echo "No konsultacija records found.";
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
<script>
    // Check for the deletion success parameter in the URL
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const deletionSuccess = urlParams.get('deletion');

        if (deletionSuccess === 'success') {
            // Display a popup message
            alert('Pasalinimas pavyko');
        }
    };
</script>
<script>
    // Check for the edit success parameter in the URL
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const editSuccess = urlParams.get('edit');

        if (editSuccess === 'success') {
            // Display a popup message for a successful edit
            alert('Pakeista sėkmingai');
        }
    };
</script>
</body>
</html>