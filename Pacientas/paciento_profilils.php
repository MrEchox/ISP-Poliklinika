<?php
require '../config.php';

$pacientasData = []; // Initialize an empty array to store patient data

if (!empty($_SESSION["id"])) {
    $sessionID = $_SESSION["id"];
    $sql = "SELECT p.* FROM pacientas p 
            INNER JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas 
            WHERE n.EPastas = '$sessionID'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pacientasData[] = $row; // Store each row in the array
        }
    } else {
        echo "No records found.";
    }
} else {
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
    <a class="right" onclick="goBack()">Grįžti</a>
</div>

<!-- Display pacientas data for the logged-in user -->
<?php
if (!empty($pacientasData)) {
    foreach ($pacientasData as $row) {
        echo '<div class="information">';
        echo '<p class="asmenineInfo">Asminė informacija</p>';
        echo '<div class="profileInfo Adresacija"><p>Adresacija</p><p>' . htmlspecialchars($row["Adresas"]) . '</p></div>';
        echo '<div class="profileInfo Asmens Kodas"><p>ID</p><p>' . htmlspecialchars($row["AsmensKodas"]) . '</p></div>';
        echo '<div class="profileInfo Darbovietė"><p>Darbovietė</p><p>' . htmlspecialchars($row["Darboviete"]) . '</p></div>';
        echo '<div class="profileInfo Amzius"><p>Amzius</p><p>' . htmlspecialchars($row["Amzius"]) . '</p></div>';
        echo '<div class="profileInfo Svoris"><p>Svoris</p><p>' . htmlspecialchars($row["Svoris"]) . ' kg</p></div>';
        echo '<div class="profileInfo Ugis"><p>Ugis</p><p>' . htmlspecialchars($row["Ugis"]) . ' cm</p></div>';
        echo '<div class="profileInfo Kraujo_grupe"><p>Kraujo grupė</p><p>' . htmlspecialchars($row["KraujoGr"]) . '</p></div>';
        echo '<div class="profileInfo Alergijos"><p>Alergijos</p><p>' . ($row["Alergijos"] ? 'Taip' : 'Ne') . '</p></div>';
        echo '</div>';
    }
} else {
    echo "No pacientas records found.";
}
?>

<!-- Additional HTML content and links -->
<a href="pacientas.php">
    <input type="button" value="Siuntimai" class="buttonAD">
</a>
<a href="paciento_profilils.html">
    <input type="button" value="Keisti vaistus" class="buttonAD">
</a>
<a href="../Pacientas/calendar.html">
    <input type="button" value="Registracijos apsilankymu istorija" class="buttonAD">
</a>

<footer>
    <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
</footer>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
