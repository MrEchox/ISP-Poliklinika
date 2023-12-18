<?php
    require '../config.php';
    if(!empty($_SESSION["id"])){
        $sessionID = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$sessionID'");
        $row = mysqli_fetch_assoc($result);
    }
    else{
        header("Location: login.php");
    }

    function submitRating($conn, $sessionID) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $visitationDate = $_POST["visitationDate"];
            $reviewRating = $_POST["reviewRating"];
            $reviewText = $_POST["reviewText"];

            $query = "INSERT INTO `atsiliepimas` (`Data`, `Ivertis`, `Komentaras`, `fk_Naudotojas_EPastas`) VALUES ('$visitationDate', '$reviewRating', '$reviewText', '$sessionID');";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Atsiliepimas sėkmingai pateiktas!');</script>";
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
        }
    }

    submitRating($conn, $sessionID)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Atsiliepimo pateikimas</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
    <!-- NAVBAR -->
    <?php
        echo '<div class="navbar">';
        echo '<a href="../index.php">Pradžia</a>';
        echo '<a href="../info.php">Informacija</a>';
        if($row["Role"] == "Svecias"){
            echo '<a href="sveciasExamView.php">Tyrimų peržiūra ir užsakymas</a>';
            echo '<a href="sveciasReviews.php">Pateikti atsiliepimą</a>';
            echo '<a href="sveciasVisitation.php">Registruotis paciento aplankymui</a>';
        }
        else{
            header("Location: ../index.php");
        }
        echo'<a class="right" href="../logout.php">Atsijungti</a>';
        echo '</div>';
    ?>
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <br>
    <!-- ---- -->

    <h2>Atsiliepimo pateikimas</h2> 
    <form method="POST">
        <label for="visitationDate">Nurodykite datą (neprivaloma)</label>
        <input type="date" id="visitationDate" name="visitationDate" class="inputfield">
        <br><br>

        <!-- Review Section -->
        <label for="reviewRating">Įvertinimas:</label>
        <br>
        <div class="rating">
            <input type="radio" id="star5" name="reviewRating" value="5">
            <label for="star5">Puikiai</label>
            <br>
            <input type="radio" id="star4" name="reviewRating" value="4">
            <label for="star4">Gerai</label>
            <br>
            <input type="radio" id="star3" name="reviewRating" value="3">
            <label for="star3">Patenkinamai</label>
            <br>
            <input type="radio" id="star2" name="reviewRating" value="2">
            <label for="star2">Prastai</label>
            <br>
            <input type="radio" id="star1" name="reviewRating" value="1">
            <label for="star1">Labai prastai</label>
        </div>
        <br><br>

        <label for="reviewText">Jūsų atsiliepimas:</label>
        <textarea name="reviewText" rows="4" cols="40" class="inputfield" required></textarea>
        <br><br>

        <input type="submit" value="Pateikti atsiliepimą">
        <br><br>
    </form>
</body>
</html>
