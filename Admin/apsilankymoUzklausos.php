
<?php
require '../config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
    $query = "SELECT k.id, k.Data, k.Laikas, 
          CONCAT(np.Vardas, ' ', np.Pavarde) as PacientoVardas, 
          CONCAT(ng.Vardas, ' ', ng.Pavarde) as GydytojoVardas 
          FROM konsultacija k
          JOIN pacientas p ON k.fk_Pacientas_AsmensKodas = p.AsmensKodas
          JOIN naudotojas np ON p.fk_Naudotojas_EPastas = np.EPastas
          JOIN gydytojas g ON k.fk_Gydytojas_id = g.id
          JOIN naudotojas ng ON g.fk_Naudotojas_EPastas = ng.EPastas";


    $konsultacijos = mysqli_query($conn, $query);
}
else{
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informacija</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
<?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        if($row["Role"] == "Administratorius"){ //tbh susitvarkyk pagal save kaip nori cia
            echo '<a href="inventorius.php">Inventorius</a>';
            echo '<a href="inventoriusUžsakymas.php">Inventoriaus užsakymas</a>';
            echo '<a href="užsakymoPeržiūra.php">Užsakymai</a>';
            echo '<a href="Administratorius.php">Keisti roles</a>';

            
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo '</div>';
    ?>
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <br>
    <!-- ---- -->
    <h2>Apsilankymo užklausos</h2>
    <div style="float: right; width: 33%;">
    <input type="text" id="filter" placeholder="Įveskite paciento vardą" style="width: 70%; display: inline-block; box-sizing: border-box; padding: 8px; border: 1px solid #ccc;">
    <button onclick="filterResults()" style="width: 28%; display: inline-block; box-sizing: border-box; padding: 8px 10px; border: 1px solid #ccc;">Filtruoti</button>
    </div>


    <table>
        <thead>
            <tr>
                <th>Pacientas</th>
                <th>Pas ką</th>
                <th>Laikas</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php 
        foreach ($konsultacijos as $item) {
         echo '<tr>';
         echo '<td>' . htmlspecialchars($item['PacientoVardas']) . '</td>';
            echo '<td>' . htmlspecialchars($item['GydytojoVardas']) . '</td>';
         echo '<td>' . htmlspecialchars($item['Laikas']) . '</td>';
            echo '<td>' . htmlspecialchars($item['Data']) . '</td>';
            echo '<td><button onclick="deleteRow(' . htmlspecialchars($item['id']) . ')">Delete</button></td>';
         echo '</tr>';
        }
            ?>
                
        </tbody>
    </table>
<script>
function filterResults() {
    var filterTerm = document.getElementById("filter").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "apsilankymoController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tableBody = document.querySelector("table tbody");
            tableBody.innerHTML = xhr.responseText;
        }
    };
    xhr.send("filterTerm=" + encodeURIComponent(filterTerm));
}
function deleteRow(konsultacijaId) {
    if (confirm("Are you sure you want to delete this record?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "apsilankymoController.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Reload the page to reflect the changes
                location.reload();
            } else {
                alert("Error deleting record.");
            }
        };
        xhr.send("delete=true&id=" + konsultacijaId);
    }
}
    </script>
</body>
</html>