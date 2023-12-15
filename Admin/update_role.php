<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $newRole = $_POST['newRole'];

    $updateQuery = "UPDATE naudotojas SET Role = '$newRole' WHERE EPastas = '$userId'";
    mysqli_query($conn, $updateQuery);

    if($newRole = "Gydytojas"){
        $addDoc = "INSERT INTO gydytojas VALUES('', 'Šeimos Gyd.', 'Nepriskirtas', '$userId')";
        mysqli_query($conn, $addDoc);
    }

    echo "alert('Rolė sėkmingai pakeista')";
}
?>
