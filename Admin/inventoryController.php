<?php

require '../config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION["id"]) && isset($_POST["itemName"], $_POST["count"], $_POST["bukle"])) {
    $sessionID = $_SESSION["id"];
    $itemName = mysqli_real_escape_string($conn, $_POST["itemName"]);
    $count = mysqli_real_escape_string($conn, $_POST["count"]);
    $bukle = mysqli_real_escape_string($conn, $_POST["bukle"]);
    $paskutinisPildymas = date('Y-m-d H:i:s'); 


    $checkQuery = "SELECT * FROM inventorius WHERE Pavadinimas = '$itemName' AND Bukle = '$bukle'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {

        $updateQuery = "UPDATE inventorius SET Kiekis = Kiekis + $count, PaskutinisPildymas = '$paskutinisPildymas' WHERE Pavadinimas = '$itemName' AND Bukle = '$bukle'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {

        $stmt = $conn->prepare("INSERT INTO inventorius (Pavadinimas, Kiekis, PaskutinisPildymas, Bukle) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $itemName, $count, $paskutinisPildymas, $bukle);

        if ($stmt->execute()) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
        $stmt->close();
    }

    $stmtUzsk = $conn->prepare("INSERT INTO uzsakymas (Pavadinimas, Kiekis, fk_Naudotojas_EPastas, Papildymas, Bukle) VALUES (?, ?, ?, ?, ?)");
    $stmtUzsk->bind_param("sisss", $itemName, $count, $sessionID, $paskutinisPildymas,$bukle);

    if ($stmtUzsk->execute()) {
        echo "Record inserted successfully in uzsk";
    } else {
        echo "Error inserting record in uzsk: " . $stmtUzsk->error;
    }
    $stmtUzsk->close();
}
else if (!empty($_SESSION["id"]) && !empty($_POST["filterTerm"])) {
    $filterTerm = mysqli_real_escape_string($conn, $_POST["filterTerm"]);
    $query = "SELECT * FROM inventorius WHERE Pavadinimas LIKE '%$filterTerm%'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['Pavadinimas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Kiekis']) . '</td>';
        echo '<td>' . htmlspecialchars($row['PaskutinisPildymas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Bukle']) . '</td>';
        echo '</tr>';
    }
}
else if (isset($_POST["startDate"], $_POST["endDate"])) {
    // Fetch records within the date range
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    
    // Prepare the query with date filtering
    $stmt = $conn->prepare("SELECT * FROM uzsakymas WHERE Papildymas BETWEEN ? AND ?");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['Pavadinimas']) . '</td>';
        echo '<td>' . htmlspecialchars($row['Papildymas']) . '</td>';
        echo '</tr>';
    }
    $stmt->close();
}

else {
    echo "Unauthorized access or action not specified.";
}


$conn->close();
?>

