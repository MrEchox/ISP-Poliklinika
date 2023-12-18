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

    function processOrder($conn, $sessionID) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $examName = $_POST["examName"];
            $illnessDesc = $_POST["illnessDesc"];

            $query = "INSERT INTO `tyrimo_uzsakymas` (`fk_Naudotojas_EPastas`, `Reikalavimas`, `Skausmai`) VALUES ('$sessionID', '$examName', '$illnessDesc');";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Užsakymas sėkmingai pateiktas!');</script>";
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
        }
    }

    processOrder($conn, $sessionID)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Užsakymų peržiūra</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <style>
        #orderForm {
            display: none;
        }
        #examDetailsPopup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        #examDetailsContent {
            background-color: #30358D;
            padding: 20px;
            width: 50%;
            margin: 100px auto;
        }
    </style>
</head>
<body>
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

    <!-- Content -->
    <div class="content">
        <!-- Button to show the form -->
        <button id="showFormButton">Užsakyti tyrimą</button>
        <br><br>

        <!-- Form to order an examination -->
        <div id="orderForm">
            <h2>Tyrimo užsakymo forma</h2>
            <form action="" method="POST">
                <label for="examName">Kokio tyrimo pageidaujama (neprivaloma):</label>
                <input type="text" id="examName" class="inputfield" name="examName">
                <label for="illnessDesc">Kuo skundžiamasi:</label>
                <input type="text" id="illnessDesc" class="inputfield" name="illnessDesc" required>

                <button type="submit">Pateikti užsakymą</button>
            </form>
        </div>
        <br><br>

        <!-- List of Examinations -->
        <div class="examinations">
            <h2>Tyrimai:</h2>
            <ul>
                <?php
                $query = "SELECT * FROM `tyrimas` WHERE `fk_Naudotojas_EPastas` = '$sessionID';";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li><a href=\"javascript:void(0);\" onclick=\"showExamDetails('{$row['Pavadinimas']}')\">{$row['Pavadinimas']}</a></li>";
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($conn);
                }
                ?>
            </ul>
        </div>

        <!-- Examination Details Popup -->
        <div id="examDetailsPopup">
            <div id="examDetailsContent">
                <h2>Tyrimo informacija</h2>
                <p>Gydytojas: <span id="examDoctorDuty"></span> <span id="examDoctorName"></span> <span id="examDoctorSurname"></span></p>
                <p>Analize: <span id="examAnalysis"></span></p>
                <p>Svarba: <span id="examImportance"></span></p>
                <p>Kaina: €<span id="examPrice"></span></p>
                <button onclick="closeExamDetails()">Uždaryti</button>
            </div>
        </div>
    </div>
    <br><br>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>

    <script>
        // JavaScript to toggle the form visibility when the button is clicked
        const showFormButton = document.getElementById("showFormButton");
        const orderForm = document.getElementById("orderForm");

        showFormButton.addEventListener("click", function() {
            if (orderForm.style.display === "none") {
                orderForm.style.display = "block";
            } else {
                orderForm.style.display = "none";
            }
        });

        // Function to show examination details in a popup
        function showExamDetails(examName) {
            const examDetailsPopup = document.getElementById("examDetailsPopup");
            const examDoctorDuty = document.getElementById("examDoctorDuty");
            const examDoctorName = document.getElementById("examDoctorName");
            const examDoctorSurname = document.getElementById("examDoctorSurname");
            const examAnalysis = document.getElementById("examAnalysis");
            const examImportance = document.getElementById("examImportance");
            const examPrice = document.getElementById("examPrice");

            // Replace with actual data for the clicked examination
            
            <?php
                $query = "SELECT * FROM `tyrimas` JOIN `gydytojas` ON tyrimas.fk_Gydytojas_id = gydytojas.id
                JOIN `naudotojas` ON gydytojas.fk_Naudotojas_EPastas = `EPastas`
                WHERE tyrimas.fk_Naudotojas_EPastas = '$sessionID';";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "if (examName === '{$row['Pavadinimas']}') {";
                        echo "examDoctorDuty.textContent = '{$row['Pareigos']}';";
                        echo "examDoctorName.textContent = '{$row['Vardas']}';";
                        echo "examDoctorSurname.textContent = '{$row['Pavarde']}';";
                        echo "examAnalysis.textContent = '{$row['Analize']}';";
                        echo "examImportance.textContent = '{$row['Svarba']}';";
                        echo "examPrice.textContent = '{$row['Kaina']}';";
                        echo "}";
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($conn);
                }
            ?>

            examDetailsPopup.style.display = "block";
        }

        // Function to close the examination details popup
        function closeExamDetails() {
            const examDetailsPopup = document.getElementById("examDetailsPopup");
            examDetailsPopup.style.display = "none";
        }
    </script>
</body>
</html>