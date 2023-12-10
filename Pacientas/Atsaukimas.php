<!DOCTYPE html>
<html>
<head>
    <title>Informacija</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="pacientas.css">
</head>
<body>
<!-- NAVBAR -->
<!-- (Your existing navbar code) -->

<h2>Atšaukimas</h2>
<form class="tableForm">
    <div class="information">
        <h2>Bendra informacija</h2>
        <!-- ... -->
    </div>
    <table>
        <tr>
            <th>Gydytojas</th>
            <th>Paskirtas laikas</th>
            <th>Registracijos Data</th>
        </tr>

        <?php
        // Database connection setup
        $servername = "localhost"; // Your server name
        $username = "root"; // Your database username
        $password = ""; // Your database password
        $dbname = "calendardb"; // Your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        $appointmentID = isset($_GET['appointmentID']) ? $_GET['appointmentID'] : 0;

        // Fetching data for the specific appointment
        $sql = "SELECT * FROM Appointments WHERE AppointmentID = $appointmentID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<tr>";
            echo "<td>Doctor's Name</td>"; // Replace with actual doctor's name if available
            echo "<td>" . $row["AppointmentDate"] . "</td>";
            echo "<td>2023-10-01</td>"; // Replace with actual registration date if available
            echo "</tr>";
        } else {
            echo "<tr><td colspan='3'>No appointment found.</td></tr>";
        }

        $conn->close();
        ?>

    </table>
    <!-- Your existing buttons and links -->
</form>

<!-- (Your existing footer code) -->
</body>
</html>
