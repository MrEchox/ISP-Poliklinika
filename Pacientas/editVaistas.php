<?php
    require '../config.php';
    if(!empty($_SESSION["id"])){
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
        if($row["Role"] != "Gydytojas"){
            header("Location: ../login.php");
        }
    }
    else{
        header("Location: ../login.php");
    }
    $email = $_GET['id'];
    $vaistasQuery = "SELECT * FROM vaistas WHERE fk_Pacientas_AsmensKodas IN (SELECT AsmensKodas FROM pacientas WHERE fk_Naudotojas_EPastas = '$email')";
    $vaistasResult = mysqli_query($conn, $vaistasQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaisto redagavimas</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
    <?php
        echo '<div class="navbar">';
            echo '<a class="right" onclick="goBack()">Grįžti</a>';
        echo '</div>';
    ?>
    <div class="vaistai">
        <h2>Vaistai</h2>
        <table>
            <?php
            if($vaistasResult->num_rows > 0){
                while ($vaistasRow = mysqli_fetch_assoc($vaistasResult)) {
                    echo '<tr>';
                        echo '<th>Pavadinimas</th>';
                        echo '<th>Galiojimo Data</th>';
                        echo '<th>Receptinis</th>';
                        echo '<th>Pavidalas</th>';
                        echo '<th>Redaguoti</th>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>' . $vaistasRow['Pavadinimas'] . '</td>';
                    echo '<td>' . $vaistasRow['GaliojimoData'] . '</td>';
                    echo '<td>' . $vaistasRow['Receptinis'] . '</td>';
                    echo '<td>' . $vaistasRow['Pavidalas'] . '</td>';
                    echo '<td><a href="editVaistasForma.php?id=' . $vaistasRow['fk_Pacientas_AsmensKodas'] . '&pavadinimas=' . $vaistasRow['Pavadinimas'] . '&galiojimoData=' . $vaistasRow['GaliojimoData'] . '&receptinis=' . $vaistasRow['Receptinis'] . '&pavidalas=' . $vaistasRow['Pavidalas'] . '">Redaguoti</a></td>';
                    echo '</tr>';
                }
            }
            else{
                echo 'Šis pacientas neturi priskirtų vaistų';
            }
            ?>
        </table>
    </div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>