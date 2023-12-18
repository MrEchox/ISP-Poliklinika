<?php
require '../config.php'; // Include the database configuration file

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the session variable for user ID is set and not empty
if (!empty($_SESSION["id"])) {
    $sessionID = $_SESSION["id"];

    // Fetch user's AsmensKodas and verify if the user is a patient
    $pacientasQuery = "SELECT AsmensKodas FROM pacientas WHERE fk_Naudotojas_EPastas = '$sessionID'";
    $pacientasResult = $conn->query($pacientasQuery);

    if ($pacientasResult && $pacientasResult->num_rows > 0) {
        $pacientasRow = $pacientasResult->fetch_assoc();
        $asmensKodas = $pacientasRow["AsmensKodas"];
    } else {
        echo "User not found or not a patient.";
        exit();
    }
} else {
    // Redirect to login page if the session ID is not set
    header("Location: login.php");
    exit();
}

$formSubmittedSuccessfully = false;

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST['Data'];
    $laikas = $_POST['Laikas'];
    $fk_Gydytojas_id = $_POST['fk_Gydytojas_id'];

    // Prepare your SQL statement and execute
    $insertQuery = "INSERT INTO konsultacija (Data, Laikas, fk_Pacientas_AsmensKodas, fk_Gydytojas_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssii", $data, $laikas, $asmensKodas, $fk_Gydytojas_id);

    if ($stmt->execute()) {
        $formSubmittedSuccessfully = true;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch specializations for the dropdown
$specializationsQuery = "SELECT DISTINCT Pareigos FROM gydytojas";
$specializationResults = $conn->query($specializationsQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Consultation</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="pacientas.css">
</head>
<body>
<div class="navbar">
    <a class="logo"><img src="../LOGO.png" alt="Logo" width="44" height="32"></a>
    <a class="right" onclick="goBack()">Grįžti</a>
</div>

<!-- Form for booking a new consultation -->
<form id="bookingForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Užsiregistruoti</h2>

    <label for="specialization">Specializacija:</label>
    <select name="specialization" id="specialization" required>
        <option value="">Pasirinkti specializaciją</option>
        <?php
        if ($specializationResults->num_rows > 0) {
            while($row = $specializationResults->fetch_assoc()) {
                echo '<option value="' . $row["Pareigos"] . '">' . $row["Pareigos"] . '</option>';
            }
        }
        ?>
    </select>

    <label for="data">Data:</label>
    <input type="date" name="Data" id="data" required>

    <label for="laikas">Laikas:</label>
    <input type="time" name="Laikas" id="laikas" required>

    <label for="gydytojas">Gydytojo gmail:</label>
    <select name="fk_Gydytojas_id" id="gydytojas" required>
        <!-- The options will be populated based on the chosen specialization -->
    </select>

    <input type="submit" value="Book">
</form>

<script>
    function goBack() {
        window.history.back();
    }
    document.getElementById('specialization').addEventListener('change', function() {
        var specialization = this.value;
        var doctorSelect = document.getElementById('gydytojas');
        doctorSelect.innerHTML = ''; // Clear existing options

        // Use AJAX to fetch doctors based on selected specialization
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_doctors.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                var doctors = JSON.parse(this.responseText);
                doctors.forEach(function(doctor) {
                    var option = document.createElement('option');
                    option.value = doctor.id;
                    option.textContent = doctor.email; // or doctor.name if you have that information
                    doctorSelect.appendChild(option);
                });
            }
        };
        xhr.send('specialization=' + specialization);
    });

    <?php if ($formSubmittedSuccessfully): ?>
    window.location.href = 'Success.html';
    <?php endif; ?>
</script>
</body>
</html>