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
        <h2>Vaisto redagavimas</h2>
        <table>
            <?php
                echo '<form action="updateVaistas.php?id=' . $_GET["id"] . '" method="POST">';
                echo '<label for="pavadinimas">Pavadinimas:</label>';
                echo '<input type="text" name="pavadinimas" value="' . $_GET['pavadinimas'] . '"><br>';
                
                echo '<label for="galiojimoData">Galiojimo Data:</label>';
                echo '<input type="date" name="galiojimoData" value="' . $_GET['galiojimoData'] . '"><br>';
                
                echo '<label for="receptinis">Receptinis:</label>';
                echo '<input type="text" name="receptinis" value="' . $_GET['receptinis'] . '"><br>';
                
                echo '<label for="pavidalas">Pavidalas:</label>';
                echo '<input type="text" name="pavidalas" value="' . $_GET['pavidalas'] . '"><br>';
                
                echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
                echo '<input type="submit" value="Išsaugoti">';
                echo '</form>';
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