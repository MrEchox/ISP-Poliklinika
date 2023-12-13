<?php
require '../config.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradžia</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="../Pacientas/pacientas.css">
</head>
<body>
    <?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        if($row["Role"] == "Gydytojas"){
            echo '<a href="gydytojas.php">Pagrindinė informacija</a>';
            echo '<a href="vaistas.php">Išrašyti vaistą</a>';
            echo '<a href="siuntimas.php">Siuntimas</a>';
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo'<a class="right" href="profile.php">Asmeninė informacija</a>';
        echo '</div>';
    ?>
    <!--Fix users: to take all from DB-->
    <p class="welcome">Sveiki prisijungę <i><?php echo $row["Vardas"] . " " . $row["Pavarde"]?></i> | Jūsų pacientai</p>
    <div class="gydytojoInfo">
        <div class="pacientai">
            <div class="pacientas pacientas1"><a href="../Pacientas/paciento_profilils.html">Jonas Jonaitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas2"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA002</sub></a></div>
            <div class="pacientas pacientas3"><a href="../Pacientas/paciento_profilils.html">Testas Testas <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas4"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas5"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas6"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas7"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas8"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas9"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>
            <div class="pacientas pacientas10"><a href="../Pacientas/paciento_profilils.html">Petras Petraitis <sub>#AAA001</sub></a></div>

        </div>
        <!-- Add in the DB after submit-->
        <div class="ataskaitos">
            <h2>Kurti naują ataskaitą</h2>
            <form action="" method="POST" class="formaAtaskaitos">
                <label for="text">Pacientas:</label>
                <select class="inputfield"> <!-- Choose from DB -->
                    <option value="default" >Pasirinkite pacientą</option>
                    <option value="1" >Jonas Jonauskas</option>
                    <option value="2">Petras Petrauskas</option>
                </select>
        
                <label for="text">Aprašymas:</label>
                <textarea type="text" id="aprasymas" name="aprasymas" class="inputfield" required rows="4" cols="50"></textarea>
        
                <input type="submit" value="Įrašyti">
                <br><br>
            </form>
        </div>
    </div>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
