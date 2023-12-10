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

<h2>Kiti gydytojai</h2>
<form class="tableForm">
    <!-- (Your existing form and search elements) -->
    <table>
        <tr>
            <th>Gydytojas</th>
            <th>Paskirtas laikas</th>
            <th>Registracijos Data</th>
            <th>Veiksmas</th>
        </tr>

        <?php
        // Database connection setup
        $servername = "localhost"; // Your server name
        $username = "root"; // Your database username
        $password = ""; // Your database password
        $dbname = "calendardb"; // Your database name


        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetching data for a specific patient (PatientID = 1)
        $sql = "SELECT * FROM Appointments WHERE PatientID = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>Doctor's Name</td>"; // Replace with actual doctor's name if available
                echo "<td>" . $row["AppointmentDate"] . "</td>";
                echo "<td>2023-10-01</td>"; // Replace with actual registration date if available
                echo "<td>
                        <a href='atsaukimas.php?appointmentID=" . $row["AppointmentID"] . "'>
                            <input type='button' value='Atšaukimas' class='buttonAD'>
                        </a>
                        <a href='Redagavimas.html'>
                            <input type='button' value='Redagavimas' class='buttonAD'>
                        </a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No appointments found.</td></tr>";
        }

        $conn->close();
        ?>

    </table>
</form>

<!-- (Your existing footer code) -->
</body>
</html>
