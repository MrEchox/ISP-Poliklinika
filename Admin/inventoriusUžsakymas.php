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
    <title>Registracija</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <style>
        .inputfield,
.inputfield[type="text"],
.inputfield[type="number"] {
    width: 100%; 
    padding: 8px; 
    border: 1px solid #ccc; 
    box-sizing: border-box; 

}
        </style>
</head>
<body>
<?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        if($row["Role"] == "Administratorius"){ //tbh susitvarkyk pagal save kaip nori cia
            echo '<a href="inventorius.php">Inventorius</a>';
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

    <h2>Užsakymas</h2> 
    <form id="orderForm" onsubmit="submitForm(event)">
    <label for="itemName">Pavadinimas:</label>
    <input type="text" id="itemName" name="itemName" class="inputfield" required>
    <br><br>

    <label for="count">Kiekis:</label>
    <input type="number" id="count" name="count" class="inputfield" required>
    <br><br>

    <label for="bukle">Būklė:</label>
    <select id="bukle" name="bukle" class="inputfield" required>
        <option value="Puiki">Puiki</option>
        <option value="Gera">Gera</option>
        <option value="Patenkinama">Patenkinama</option>
    </select>
    <br><br>

    <input type="submit" value="Order">
</form>

<script>
    function submitForm(e) {
        e.preventDefault(); 

        var itemName = document.getElementById("itemName").value;
        var count = document.getElementById("count").value;
        var bukle = document.getElementById("bukle").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "inventoryController.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);

                // Clear the form fields
                document.getElementById("itemName").value = "";
                document.getElementById("count").value = "";
                document.getElementById("bukle").value = "Puiki"; // Reset to default or an empty string
            }
        };
        var data = "itemName=" + encodeURIComponent(itemName) +
                   "&count=" + encodeURIComponent(count) +
                   "&bukle=" + encodeURIComponent(bukle);
        xhr.send(data);
    }

</script>
</body>
</html>
