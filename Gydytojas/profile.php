<?php
require '../config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
    $query = mysqli_query($conn, "SELECT * FROM gydytojas where fk_Naudotojas_EPastas = '$sessionID'");
    $doc = mysqli_fetch_assoc($query);
}
else{
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pradžia</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="../Pacientas/pacientas.css">
</head>
<body>
    <!-- NAVBAR -->
    <?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        if($row["Role"] == "Gydytojas")
        {
            echo '<a href="gydytojas.php">Į sistemą</a>';
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo '</div>';
    ?>

    <div class="information">
        <p class="asmenineInfo">Asminė informacija</p>
        <div class="profileInfo identifikacija">
            <p>Id</p>
            <p><?php echo $doc["id"]?></p>
        </div>
        <div class="profileInfo vardas">
            <p>Vardas</p>
            <p><?php echo $row["Vardas"]?></p>
        </div>
        <div class="profileInfo pavarde">
            <p>Pavarde</p>
            <p><?php echo $row["Pavarde"]?></p>
        </div>
        <div class="profileInfo telefonas">
            <p>Telefono Nr</p>
            <p><?php echo $row["TelefonoNr"]?></p>
        </div>
        <div class="profileInfo pareigos">
            <p>Pareigos</p>
            <p><?php echo $doc["Pareigos"]?></p>
        </div>
        <div class="profileInfo kabinetas">
            <p>Kabinetas</p>
            <p><?php echo $doc["Kabinetas"]?></p>
        </div>
    </div>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
