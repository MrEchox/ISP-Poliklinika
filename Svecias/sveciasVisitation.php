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

    function submitVisitation($conn, $sessionID) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $patientName = $_POST["patientName"];
            $date = $_POST["date"];
            $relationship = $_POST["relationship"];

            $query = "INSERT INTO `lankymas` (`paciento_varpav`, `data`, `santykis`, `fk_Naudotojas_EPastas`) VALUES ('$patientName', '$date', '$relationship', '$sessionID');";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Apsilankymas sėkmingai pateiktas!');</script>";
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
        }
    }

    submitVisitation($conn, $sessionID)
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

        <label for="date">Kada norite aplankyti:</label>
        <input type="date" id="date" name="date" class="inputfield" required>
        <br><br>

        <label for="relationship">Santykiai su pacientu:</label>
        <select id="relationship" name="relationship" class="inputfield" required>
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
