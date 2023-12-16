<?php

require '../config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
    $sql = mysqli_query($conn, "SELECT * FROM uzsakymas");
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
        if($row["Role"] == "Administratorius"){ //tbh susitvarkyk pagal save kaip nori cia
            echo '<a href="inventorius.php">Inventorius</a>';
            echo '<a href="inventoriusUžsakymas.php">Inventoriaus užsakymas</a>';
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
    <h2>Inventoriaus peržiūra</h2>

    <div style="float: right; width: 33%; white-space: nowrap;">
    <label for="startDate" style="display: inline-block; margin-right: 5px; vertical-align: top;">Nuo:</label>
    <input type="date" id="startDate" name="startDate" style="width: calc(30% - 12px); display: inline-block; box-sizing: border-box; padding: 8px; border: 1px solid #ccc; margin-right: 5px; vertical-align: top;">

    <label for="endDate" style="display: inline-block; margin-right: 5px; vertical-align: top;">Iki:</label>
    <input type="date" id="endDate" name="endDate" style="width: calc(30% - 12px); display: inline-block; box-sizing: border-box; padding: 8px; border: 1px solid #ccc; margin-right: 5px; vertical-align: top;">

    <button onclick="filterResults()" style="width: calc(30% - 12px); display: inline-block; box-sizing: border-box; padding: 8px 10px; border: 1px solid #ccc; vertical-align: top;">Filtruoti</button>
</div>


<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Papildoma informacija apie užsakymą</h2> <!-- Header added here -->
    <p><strong>Kiekis:</strong> <span id="Kiekis"></span></p>
    <p><strong>Būklė:</strong> <span id="Bukle"></span></p>
    <p><strong>Kas užsakė:</strong> <span id="modalKasUzsake"></span></p>
  </div>
</div>




    <table>
        <thead>
            <tr>
                <th>Pavadinimas</th>
                <th>Paskutinis pildymas</th>
            </tr>
        </thead>
        <tbody>
        <?php 
foreach ($inventorius as $item){
    echo '<tr onclick="showModal(this)" data-kiekis="' . htmlspecialchars($item['Kiekis']) . '" data-bukle="' . htmlspecialchars($item['Bukle']) . '" data-email="' . htmlspecialchars($item['fk_Naudotojas_EPastas']) . '">';
    echo '<td> ' . htmlspecialchars($item['Pavadinimas']) . '</td>';
    echo '<td> ' . htmlspecialchars($item['Papildymas']) . '</td>';
    echo '</tr>';
} 
?>

        </tbody>
    </table>
    
<script>
function filterResults()
 {
    var startDate = document.getElementById("startDate").value;
    var endDate = document.getElementById("endDate").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tableBody = document.querySelector("table tbody");
            tableBody.innerHTML = xhr.responseText;
        }
    };
    xhr.send("startDate=" + encodeURIComponent(startDate) + "&endDate=" + encodeURIComponent(endDate));
}
function showModal(row) {
    // Retrieve the data attributes from the clicked row
    var kiekis = row.getAttribute('data-kiekis');
    var bukle = row.getAttribute('data-bukle');
    var email = row.getAttribute('data-email');

    // Populate the modal fields
    document.getElementById('Kiekis').textContent = kiekis;
    document.getElementById('Bukle').textContent = bukle;
    document.getElementById('modalKasUzsake').textContent = email;

    // Display the modal
    modal.style.display = 'block';
}


var modal = document.getElementById('myModal');
var closeBtn = document.getElementsByClassName('close')[0];
closeBtn.onclick = function() {
    modal.style.display = 'none';
};


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

</script>


</body>
</html>