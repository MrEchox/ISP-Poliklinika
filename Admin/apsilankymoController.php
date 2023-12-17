<?php

require '../config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION["id"]) && !empty($_POST["filterTerm"])) {
    $filterTerm = mysqli_real_escape_string($conn, $_POST["filterTerm"]);
    $query = "SELECT k.Data, k.Laikas, 
                 CONCAT(np.Vardas, ' ', np.Pavarde) as PacientoVardas, 
                 CONCAT(ng.Vardas, ' ', ng.Pavarde) as GydytojoVardas 
          FROM konsultacija k
          JOIN pacientas p ON k.fk_Pacientas_AsmensKodas = p.AsmensKodas
          JOIN naudotojas np ON p.fk_Naudotojas_EPastas = np.EPastas
          JOIN gydytojas g ON k.fk_Gydytojas_id = g.id
          JOIN naudotojas ng ON g.fk_Naudotojas_EPastas = ng.EPastas
          WHERE np.Vardas LIKE '%$filterTerm%'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['PacientoVardas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['GydytojoVardas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Laikas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Data']) . '</td>';
        echo '</tr>';
    }
}
else if (!empty($_SESSION["id"]) && isset($_POST['delete']) && !empty($_POST["id"])) {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    $query = "DELETE FROM konsultacija WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record";
    }

    $stmt->close();
}
$conn->close();
?>