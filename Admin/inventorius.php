<?php
require '../config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
    $sql = mysqli_query($conn, "SELECT * FROM inventorius");
    $inventorius = mysqli_fetch_all($sql, MYSQLI_ASSOC);
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
        if($row["Role"] == "Administratorius"){ 
            echo '<a href="inventoriusUžsakymas.php">Inventoriaus užsakymas</a>';
            echo '<a href="užsakymoPeržiūra.php">Užsakymai</a>';
            echo '<a href="apsilankymoUzklausos.php">Apsilankymo Užklausos</a>';
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
    <h2>Inventoriaus peržiūra</h2>

    <div style="float: right; width: 33%;">
    <input type="text" id="filter" placeholder="Įveskite daikto pavadinimą" style="width: 70%; display: inline-block; box-sizing: border-box; padding: 8px; border: 1px solid #ccc;">
    <button onclick="filterResults()" style="width: 28%; display: inline-block; box-sizing: border-box; padding: 8px 10px; border: 1px solid #ccc;">Filtruoti</button>
    </div>


    <table>
        <thead>
            <tr>
                <th>Pavadinimas</th>
                <th>Kiekis</th>
                <th>Paskutinis pildymas</th>
                <th>Būklė</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($inventorius as $item){
                    echo '<tr>';
                    echo '<td> ' . $item['Pavadinimas'] . '</td>';
                    echo '<td> ' . $item['Kiekis'] . '</td>';
                    echo '<td> ' . $item['PaskutinisPildymas'] . '</td>';
                    echo '<td> ' . $item['Bukle'] . '</td>';
                    echo '</tr>';
                } 
            ?>
        </tbody>
    </table>
    
<script>
    function filterResults() {
    var filterTerm = document.getElementById("filter").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tableBody = document.querySelector("table tbody");
            tableBody.innerHTML = xhr.responseText;
        }
    };
    xhr.send("filterTerm=" + encodeURIComponent(filterTerm));
}
</script>


</body>
</html>