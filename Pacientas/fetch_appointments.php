<?php
    require '../config.php';
    if(!empty($_SESSION["id"])){
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
    }
    else{
        header("Location: ../login.php");
    }

    if (isset($_GET["id"])) {
        $patientId = $_GET["id"];
        $sql = "SELECT DISTINCT Data 
                FROM konsultacija 
                WHERE fk_Pacientas_AsmensKodas = '$patientId'";
    }

$result = $conn->query($sql);
if (!$result) {
    // Handle the database query error
    echo "Error executing the query: " . $conn->error;
    exit;  // Stop execution or redirect to an error page
}
$appointmentsDates = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointmentsDates[] = $row['Data'];
    }
} else {
    $appointmentsDates[] = [];
}

// Set header to output JSON
header('Content-Type: application/json');
// Echo the dates with appointments in JSON format
echo json_encode($appointmentsDates);

$conn->close();
?>
