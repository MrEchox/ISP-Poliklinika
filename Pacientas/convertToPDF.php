<?php
    require '../config.php';

    if (!empty($_SESSION["id"])) {
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location: ../login.php");
    }

    if (isset($_GET["data"])) {
        $pacientasDataJSONString = $_GET["data"];
        $pacientasDataJSON = json_decode(urldecode($pacientasDataJSONString), true);

        // Extract Gydytojas data based on "fk_Gydytojas_id"
        $gydytojasId = $pacientasDataJSON[0]['fk_Gydytojas_id'];
        $gydytojasQuery = "SELECT n.Vardas, n.Pavarde FROM gydytojas g
                            JOIN naudotojas n ON g.fk_Naudotojas_EPastas = n.EPastas
                            WHERE g.id = $gydytojasId";
        $gydytojasResult = mysqli_query($conn, $gydytojasQuery);
        $gydytojasData = mysqli_fetch_assoc($gydytojasResult);

        // Extract GydytojoKomentarai from ataskaita table
        $asmensKodas = $pacientasDataJSON[0]['AsmensKodas'];
        $komentaraiQuery = "SELECT GydytojoKomentarai FROM ataskaita WHERE fk_Pacientas_id = $asmensKodas";
        $komentaraiResult = mysqli_query($conn, $komentaraiQuery);
        
        $komentaraiData = [];
        while ($row = mysqli_fetch_assoc($komentaraiResult)) {
            $komentaraiData[] = $row['GydytojoKomentarai'];
        }

        // Combine patient, doctor, and comments data
        $combinedData = $pacientasDataJSON[0];
        $combinedData['Gydytojas'] = $gydytojasData['Vardas'] . ' ' . $gydytojasData['Pavarde'];
        $combinedData['Gydytojo komentarai'] = $komentaraiData;
        unset($combinedData['fk_Gydytojas_id']); // Remove old Gydytojas ID

    } else {
        // Handle the case where data parameter is not set
        // You may want to redirect or show an error message
        header("Location: ../error.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
    <title>PDF</title>
</head>
<body>
    <h2><a href="../Gydytojas/gydytojas.php">Atgal į sistemą</a></h2>

    <script>
        var doc = new jsPDF();
        var dataObject = <?php echo json_encode($combinedData); ?>;

        Object.keys(dataObject).forEach((key, i) => {
            var label;
            if (key === 'fk_Naudotojas_EPastas') {
                label = 'Paciento E-paštas';
            } else {
                label = key;
            }

            if (Array.isArray(dataObject[key])) {
                // For 'Gydytojo komentarai', add each comment on a new line
                doc.text(50, 10 + (i * 10), `${label}:`);
                dataObject[key].forEach((comment, j) => {
                    doc.text(60, 20 + (i * 10) + (j * 10), ` - ${comment}`);
                });
            } else {
                // For other keys, display normally
                doc.text(50, 10 + (i * 10), `${label}: ${dataObject[key]}`);
            }
        });

        doc.save('convertedPDF.pdf');
    </script>
</body>
</html>
