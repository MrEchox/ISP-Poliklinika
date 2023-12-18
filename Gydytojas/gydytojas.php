<?php
    require '../config.php';
    if(!empty($_SESSION["id"])){
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
    }
    else{
        header("Location: ../login.php");
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
    <p class="welcome">Sveiki prisijungę <i><?php echo $row["Vardas"] . " " . $row["Pavarde"]?></i> | Jūsų pacientai</p>
    <div class="gydytojoInfo">
        <div class="pacientai">
            <?php 
                $currentDocId = mysqli_query($conn, "SELECT id FROM gydytojas where fk_Naudotojas_EPastas = '$sessionID'");
                if ($currentDocId) {
                    while ($row = mysqli_fetch_assoc($currentDocId)) {
                        $query = "SELECT n.Vardas AS Vardas, n.Pavarde AS Pavarde, n.EPastas AS email
                                FROM pacientas p JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas
                                LEFT JOIN gydytojas g ON p.fk_Gydytojas_id = g.id
                                WHERE g.id = '" . $row["id"] . "'";
                        $result = mysqli_query($conn, $query);

                        $numRows = mysqli_num_rows($result);
                        if ($numRows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="pacientas">';
                                    echo '<a href="../Pacientas/paciento_profilils.php?email=' . $row['email'] . '">';
                                    echo $row['Vardas'] . ' ' . $row['Pavarde'] . "<br>";
                                    echo '</a>';
                                echo '</div>';
                            }
                        } else {
                            echo '<h1 style="color: #fff;">Šiuo metu jūs neturite pacientų</h1>';
                        }
                    }
                }
            ?>
        </div>
        <div class="ataskaitos">
            <h2>Kurti naują ataskaitą</h2>
            <form action="" method="POST" class="formaAtaskaitos">
                <label for="text">Pacientas:</label>
                <select name="selectedPatient" class="inputfield"> 
                    <option value="default" >Pasirinkite pacientą</option>
                    <?php 
                    $currentDocId = mysqli_query($conn, "SELECT id FROM gydytojas where fk_Naudotojas_EPastas = '$sessionID'");

                    if ($currentDocId) {
                        while ($docRow = mysqli_fetch_assoc($currentDocId)) {
                            $query = "SELECT n.Vardas AS Vardas, n.Pavarde AS Pavarde
                                FROM pacientas p JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas
                                LEFT JOIN gydytojas g ON p.fk_Gydytojas_id = g.id
                                WHERE g.id = '" . $docRow["id"] . "'";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $fullName = $row['Vardas'] . ' ' . $row['Pavarde'];
                                    echo "<option value=\"{$fullName}\">{$fullName}</option>";
                                }
                            } else {
                                echo "Error executing query: " . mysqli_error($conn);
                            }
                        }
                    }
                    ?>
                </select>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $selectedPatient = $_POST["selectedPatient"];
                        $aprasymas = $_POST["aprasymas"];
                        
                        $query = "SELECT p.AsmensKodas, n.Vardas AS Vardas, n.Pavarde AS Pavarde 
                            FROM pacientas p JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas 
                            WHERE CONCAT(n.Vardas, ' ', n.Pavarde) = '$selectedPatient'";

                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $pacientoID = $row['AsmensKodas'];

                            $insertReportQuery = "INSERT INTO ataskaita 
                                (Data, AtaskaitosId, GydytojoKomentarai, fk_Pacientas_id)
                                VALUES (NOW(), '', '$aprasymas', '$pacientoID')";

                            $insertReportResult = mysqli_query($conn, $insertReportQuery);
                            if ($insertReportResult) {
                                echo '<script>alert("Ataskaita sėkmingai sukurta");</script>';
                            } else {
                                echo '<script>alert("Nepavyko sukurti ataskaitos:");</script>';
                            }
                        } else {
                            echo '<script>alert("Nepasirinktas pacientas");</script>';
                        }
                    }
                ?>
                <label for="text">Aprašymas:</label>
                <textarea type="text" id="aprasymas" name="aprasymas" class="inputfield" required rows="4" cols="50"></textarea>
        
                <button type="submit">Įrašyti</button>
            </form>
        </div>
    </div>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
