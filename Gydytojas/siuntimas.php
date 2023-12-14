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
    <title>Siuntimas</title>
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
 

    <div class="siuntimas">
        <h2>Kurti naują siuntimą</h2>
        <form action="" method="POST" class="formaSiuntimo">
            <label for="text">Pacientas:</label>
            <select name="selectedPatient" class="inputfield">
                <option value="default" >Pasirinkite pacientą</option>
                <?php 
                    $currentDocId = mysqli_query($conn, "SELECT id FROM gydytojas where fk_Naudotojas_EPastas = '$sessionID'");

                    if ($currentDocId) {
                        while ($docRow = mysqli_fetch_assoc($currentDocId)) {
                            $query = "SELECT AsmensKodas, n.Vardas AS Vardas, n.Pavarde AS Pavarde
                                FROM pacientas p JOIN naudotojas n ON p.fk_Naudotojas_EPastas = n.EPastas
                                LEFT JOIN gydytojas g ON p.fk_Gydytojas_id = g.id
                                WHERE g.id = '" . $docRow["id"] . "'";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $fullName = $row['Vardas'] . ' ' . $row['Pavarde'];
                                    echo "<option value=\"{$row['AsmensKodas']}\">{$fullName}</option>";
                                }
                            } else {
                                echo "Error executing query: " . mysqli_error($conn);
                            }
                        }
                    }
                ?>
            </select>
        
            <label for="text">Daktaras:</label>
            <select name="selectedDoctor" class="inputfield">
                <option value="default" >Pasirinkite daktarą</option>
                <?php 
                    $query = "SELECT g.id as GydytojoID, n.Vardas AS Vardas, n.Pavarde AS Pavarde, g.Pareigos AS Pareigos
                        FROM gydytojas g JOIN naudotojas n ON g.fk_Naudotojas_EPastas = n.EPastas";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fullName = $row['Pareigos'] . ' ' . $row['Vardas'] . ' ' . $row['Pavarde'];
                            echo "<option value=\"{$row['GydytojoID']}\">{$fullName}</option>";
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                ?>
            </select>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $selectedPatient = $_POST["selectedPatient"];
                    $selectedDoctor = $_POST["selectedDoctor"];
                    
                    $patientID = (int)explode(": ", $selectedPatient)[0];
                    $doctorID = (int)explode(": ", $selectedDoctor)[0];
                    $updateQuery = "UPDATE pacientas SET fk_Gydytojas_id = $doctorID WHERE AsmensKodas = $patientID";
                    $updateResult = mysqli_query($conn, $updateQuery);
            
                    if ($updateResult) {
                        echo '<script>alert("Paciento gydytojas sėkmingai pakeistas.");</script>';
                    } else {
                        echo "Nepavyko pakeisti paciento gydytojo: " . mysqli_error($conn);
                    }
                }
            ?>
            <button type="submit">Keisti</button>
        </form>
    </div>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
