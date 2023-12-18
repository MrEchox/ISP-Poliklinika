<?php
    require '../config.php';
    if (!empty($_SESSION["id"])) {
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
        if ($row["Role"] != "Gydytojas") {
            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }
    $pavadinimas = $_POST["pavadinimas"];
    $galiojimoData = $_POST["galiojimoData"];
    $receptinis = $_POST["receptinis"];
    $pavidalas = $_POST["pavidalas"];
    $pacientasAsmensKodas = $_GET["id"];

    $updateQuery = "UPDATE vaistas 
                    SET Pavadinimas = '$pavadinimas',
                        GaliojimoData = '$galiojimoData',
                        Receptinis = '$receptinis',
                        Pavidalas = '$pavidalas'
                    WHERE fk_Pacientas_AsmensKodas = $pacientasAsmensKodas";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo '<script>';
        echo 'alert("Vaistas pakeistas sėkmingai");';
        echo 'window.location.href="../Gydytojas/gydytojas.php";';
        echo '</script>';
    } else {
        echo "Error updating values: " . mysqli_error($conn);
    }
?>