<?php
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "isp"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch the fk_Naudotojas_EPastas field from pacientas and Data from siuntimas
$sql = "SELECT p.fk_Naudotojas_EPastas, s.Data 
        FROM pacientas p 
        INNER JOIN siuntimas s ON p.AsmensKodas = s.`fk_Pacientas-AsmensKodas` 
        WHERE p.AsmensKodas = 1";

$result = $conn->query($sql);

$emailAndDates = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $emailAndDates[] = [
            'email' => $row['fk_Naudotojas_EPastas'],
            'date' => $row['Data']
        ];
    }
} else {
    echo "0 results";
}

// Set header to output JSON
header('Content-Type: application/json');
// Echo the email addresses and dates in JSON format
echo json_encode($emailAndDates);

$conn->close();
?>



