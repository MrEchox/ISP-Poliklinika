<?php
require '../config.php'; // Include the database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['specialization'])) {
    $specialization = $conn->real_escape_string($_POST['specialization']);

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, fk_Naudotojas_EPastas FROM gydytojas WHERE Pareigos = ?");
    $stmt->bind_param("s", $specialization);
    $stmt->execute();
    $result = $stmt->get_result();

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = [
            'id' => $row['id'],
            'email' => $row['fk_Naudotojas_EPastas'] // Use the email as the name for the dropdown
        ];
    }

    // Set header to application/json for proper ajax response handling
    header('Content-Type: application/json');
    echo json_encode($doctors);
} else {
    echo json_encode(['error' => 'Invalid request']);
}

?>
