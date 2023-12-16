<?php
require '../config.php';
if(!empty($_SESSION["id"])){
    $sessionID = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
    $row = mysqli_fetch_assoc($result);
    $sql = mysqli_query($conn, "SELECT * FROM naudotojas WHERE Role = 'Svecias'");
    $sveciai = mysqli_fetch_all($sql, MYSQLI_ASSOC);
}
else{
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
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
            echo '<a href="apsilankymoUzklausos.php">Apsilankymo Užklausos</a>';
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo '</div>';
    ?>
    <table>
        <thead>
            <tr>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>E-paštas</th>
                <th>Telefono nr</th>
                <th>Rolė</th>
                <th>Keisti rolę</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($sveciai as $svecias){
                    echo '<tr>';
                    echo '<td> ' . $svecias['Vardas'] . '</td>';
                    echo '<td> ' . $svecias['Pavarde'] . '</td>';
                    echo '<td> ' . $svecias['EPastas'] . '</td>';
                    echo '<td> ' . $svecias['TelefonoNr'] . '</td>';
                    echo '<td> ' . $svecias['Role'] . '</td>';
                    echo '<td>';
                    echo '<button class="changeRoleBtn" data-user-id="' . $svecias['EPastas'] . '">Keisti</button>';
                    echo '<div class="roleDropdown" style="display: none;">';
                    echo '<input type="hidden" class="userIdInput" value="' . $svecias['EPastas'] . '">';
                    echo '<select class="newRoleSelect">';
                    echo '<option value="Svecias">Svecias</option>';
                    echo '<option value="Gydytojas">Gydytojas</option>';
                    echo '<option value="Pacientas">Pacientas</option>';
                    echo '<option value="Administratorius">Administratorius</option>';
                    echo '</select>';
                    echo '<button class="submitRoleBtn">Submit</button>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                } 
            ?>
        </tbody>
    </table>
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.changeRoleBtn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.roleDropdown').forEach(function (dropdown) {
                        dropdown.style.display = 'none';
                    });

                    var dropdown = btn.nextElementSibling;
                    dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
                });
            });

            document.querySelectorAll('.submitRoleBtn').forEach(function (submitBtn) {
                submitBtn.addEventListener('click', function () {
                    var userId = submitBtn.previousElementSibling.value;
                    var newRole = submitBtn.previousElementSibling.previousElementSibling.value;
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'update_role.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            location.reload();
                        }
                    };

                    xhr.send('userId=' + newRole + '&newRole=' + userId);
                    submitBtn.closest('.roleDropdown').style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>
    