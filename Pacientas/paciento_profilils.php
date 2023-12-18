<?php
require '../config.php';

$pacientasData = []; // Initialize an empty array to store patient data

if (!empty($_SESSION["id"])) {
    $sessionID = $_SESSION["id"];
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
$roleArray = mysqli_query($conn, "SELECT Role FROM naudotojas WHERE EPastas = '$sessionID'");

if($roleArray){
    while($role = mysqli_fetch_assoc($roleArray)){
        if($role["Role"] == "Gydytojas"){
            $email = $_GET['email'];
            $currentDocId = mysqli_query($conn, "SELECT id FROM gydytojas where fk_Naudotojas_EPastas = '$sessionID'");
            if ($currentDocId) {
                while ($row = mysqli_fetch_assoc($currentDocId)) {
                    $sql = "SELECT p.*
                    FROM pacientas p JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas
                    WHERE n.EPastas = '$email'";
                }
            }
        }
        else if($role["Role"] == "Pacientas"){
            $sql = "SELECT p.* FROM pacientas p 
            INNER JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas 
            WHERE n.EPastas = '$sessionID'";
        }
        $result = mysqli_query($conn, $sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pacientasData[] = $row;
                if (!empty($pacientasData)) {
                    foreach ($pacientasData as $row) {
                        echo '<div class="information">';
                        echo '<p class="asmenineInfo">Asminė informacija</p>';
                        echo '<div class="profileInfo Adresacija"><p>Adresas</p><p>' . htmlspecialchars($row["Adresas"]) . '</p></div>';
                        echo '<div class="profileInfo AsmensKodas"><p>Asmens kodas</p><p>' . htmlspecialchars($row["AsmensKodas"]) . '</p></div>';
                        echo '<div class="profileInfo Darbovietė"><p>Darbovietė</p><p>' . htmlspecialchars($row["Darboviete"]) . '</p></div>';
                        echo '<div class="profileInfo Amzius"><p>Amžius</p><p>' . htmlspecialchars($row["Amzius"]) . '</p></div>';
                        echo '<div class="profileInfo Svoris"><p>Svoris</p><p>' . htmlspecialchars($row["Svoris"]) . ' kg</p></div>';
                        echo '<div class="profileInfo Ugis"><p>Ūgis</p><p>' . htmlspecialchars($row["Ugis"]) . ' cm</p></div>';
                        echo '<div class="profileInfo Kraujo_grupe"><p>Kraujo grupė</p><p>' . htmlspecialchars($row["KraujoGr"]) . '</p></div>';
                        echo '<div class="profileInfo Alergijos"><p>Alergijos</p><p>' . ($row["Alergijos"] ? 'Taip' : 'Ne') . '</p></div>';
                        echo '</div>';
                        if($role["Role"] == "Gydytojas"){
                            $patientID = $row["AsmensKodas"];
                        }
                    }
                } else {
                    echo "No pacientas records found.";
                }
            }
        } else {
            echo "No records found.";
        }
    }
}
?>

<?php
$roleArray = mysqli_query($conn, "SELECT Role FROM naudotojas WHERE EPastas = '$sessionID'");
if ($roleArray) {
    while ($role = mysqli_fetch_assoc($roleArray)) {
        if ($role["Role"] == "Gydytojas") {
            // Buttons for doctor
            echo '<a href="editVaistas.php?id=' . $email . '">';
            echo '<input type="button" value="Keisti vaistus" class="buttonAD">';
            echo '</a>';
            echo '<a href="../Pacientas/calendar.php?id=' . $patientID . '">';
            echo '<input type="button" value="Apsilankymų istorija" class="buttonAD">';
            echo '</a>';
            echo '<a onclick="confirmConversion()">';
            echo '<input type="button" value="Konvertuoti į PDF" class="buttonAD">';
            echo '</a>';
        } else {
            // Buttons for other users
            echo '<a href="vaistai.php">';
            echo '<input type="button" value="Vaistai" class="buttonAD">';
            echo '</a>';
            echo '<a href="tyrimas.php">';
            echo '<input type="button" value="Tyrimai" class="buttonAD">';
            echo '</a>';
            echo '<a href="konsultacijos.php">';
            echo '<input type="button" value="Konsultacijos" class="buttonAD">';
            echo '</a>';
            echo '<a href="pacientas.php">';
            echo '<input type="button" value="Siuntimai" class="buttonAD">';
            echo '</a>';
        }
    }
}
?>
<footer>
    <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
</footer>
<script>
    function goBack() {
        window.history.back();
    }
    function confirmConversion() {
    var confirmed = confirm("Ar tikrai norite konvertuoti į PDF?");
    if (confirmed) {
        var pacientasDataJSON = <?php echo json_encode($pacientasData); ?>;
        var pacientasDataJSONString = encodeURIComponent(JSON.stringify(pacientasDataJSON));

        alert("Konvertavimas sėkmingas!");

        setTimeout(function() {
            window.location.href = "convertToPDF.php?data=" + pacientasDataJSONString;
        }, 1000);
    }
}

</script>
</body>
</html>
