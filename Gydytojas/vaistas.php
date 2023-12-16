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
    <title>Vaistai</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="gydytojas.css">
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
    

    <h2>Išrašyti vaistą</h2> 
    <form action="" method="POST" class="formaVaisto">
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
                $vaistoPavadinimas = $_POST["vaisto_pavadinimas"];
            
                $galiojimoData = date('Y-m-d', strtotime('+1 year'));
            
                $query = "SELECT p.AsmensKodas 
                        FROM pacientas p 
                        JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas 
                        WHERE CONCAT(n.Vardas, ' ', n.Pavarde) = '$selectedPatient'";
                $result = mysqli_query($conn, $query);
            
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $pacientoAsmensKodas = $row['AsmensKodas'];
            
                    // Insert into vaistas table
                    $insertVaistasQuery = "INSERT INTO vaistas 
                                        (Pavadinimas, GaliojimoData, Receptinis, Pavidalas, fk_Pacientas_AsmensKodas)
                                        VALUES ('$vaistoPavadinimas', '$galiojimoData', 'Ne', '', '$pacientoAsmensKodas')";
                    $insertVaistasResult = mysqli_query($conn, $insertVaistasQuery);
            
                    if ($insertVaistasResult) {
                        echo '<script>alert("Vaistas įrašytas sėkmingai!");</script>';
                    } else {
                        echo "Error inserting vaistas: " . mysqli_error($conn);
                    }
                } else{
                    echo '<script>alert("Nepasirinktas pacientas");</script>';
                }
            }
        ?>

        <label for="text">Vaisto pavadinimas:</label>
        <input type="text" id="vaisto_pavadinimas" name="vaisto_pavadinimas" class="inputfield" required placeholder="Vaisto kodas">

        <button type="submit">Įrašyti</button>
    </form>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
