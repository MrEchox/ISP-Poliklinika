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
    <title>Paciento aplankymas</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
    <!-- NAVBAR -->
    <?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        echo '<a href="../info.php">Informacija</a>';
        if($row["Role"] == "Svecias"){
            echo '<a href="sveciasExamView.php">Tyrimų peržiūra ir užsakymas</a>';
            echo '<a href="sveciasReviews.php">Pateikti atsiliepimą</a>';
            echo '<a href="sveciasVisitation.php">Registruotis paciento aplankymui</a>';
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo '</div>';
    ?>
    <!-- ---- -->

    <h2>Registracija paciento aplankymui</h2> 
    <form method="POST"> <!-- Change action into smt that actually does smt-->
        <label for="patientName">Paciento vardas ir pavardė:</label>
        <input type="text" id="patientName" name="patientName" class="inputfield" required>
        <br><br>

        <label for="visitationDate">Kada norite aplankyti:</label>
        <input type="date" id="visitationDate" name="visitationDate" class="inputfield" required>
        <br><br>

        <label for="visitationRelationship">Santykiai su pacientu:</label>
        <select id="visitationRelationship" name="visitationRelationship" class="inputfield" required>
            <option value="family">Šeima/Globėjas</option>
            <option value="spouse">Sutuoktinis</option>
            <option value="spouse">Draugas</option>
            <option value="spouse">Bendradarbis</option>
            <option value="other">Kita</option>
        </select>
        <br><br>

        <input type="submit" value="Registruotis aplankymui">
        <br><br>

</body>
</html>
