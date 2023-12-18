<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pradžia</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <?php
        echo '<div class="navbar">';
        echo '<a href="index.php">Pradžia</a>';
        if($row["Role"] == "Gydytojas")
        {
            echo '<a href="Gydytojas/gydytojas.php">Į sistemą</a>';
        }
        else if($row["Role"] == "Administratorius"){
            echo '<a href="Admin/inventorius.php">Inventorius</a>';
            echo '<a href="Admin/inventoriusUžsakymas.php">Inventoriaus užsakymas</a>';
            echo '<a href="Admin/užsakymoPeržiūra.php">Užsakymai</a>';
            echo '<a href="Admin/apsilankymoUzklausos.php">Apsilankymo Užklausos</a>';
            echo '<a href="Admin/Administratorius.php">Keisti roles</a>';

        }
        else if($row["Role"] == "Pacientas"){
            echo '<a href="Pacientas/paciento_profilils.php">Paciento profilis</a>';
            echo '<a href="Pacientas/demo.php">Registracija</a>';
            echo '<a href="Pacientas/calendar.php">Kalendorius</a>';//gali ir cia prisidet jei nori, make it make sense krc
        }
        else if($row["Role"] == "Svecias"){
            echo '<a href="Svecias/svecias.php">Į sistemą</a>';
        }
        echo'<a class="right" href="logout.php">Atsijungti</a>';
        echo '</div>';
    ?>
    
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
