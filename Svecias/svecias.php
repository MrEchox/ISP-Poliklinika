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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pradžia</title>
    <link rel="stylesheet" href="../stylesheet.css">
</head>
<body>
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
    <p class="welcome">Sveiki prisijungę <i><?php echo $row["Vardas"] . " " . $row["Pavarde"]?></i></p>
    <div class="sveciasInfo">
        <br><br><br><hr><br><h3 style="color: white;">Informacija apie ligoninę</h3><br><br>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum tempus velit quis mattis. Aenean at dolor eu ipsum suscipit dictum. Suspendisse lorem mi, bibendum et erat interdum, bibendum vulputate ipsum. Donec hendrerit iaculis odio non rutrum. Fusce dictum, magna at porta convallis, nunc libero euismod neque, ac tristique metus dui cursus magna. Fusce vitae dui laoreet, scelerisque magna vel, vulputate tellus. Nunc ut condimentum libero. Mauris porttitor sem malesuada arcu fermentum, a sodales velit finibus. Donec dignissim elementum sem at posuere. Morbi quis interdum urna, ac tempor est. Duis nec tortor vitae justo finibus condimentum. Morbi sodales enim vel libero sagittis, eget sodales arcu mollis. Praesent facilisis erat sit amet orci dapibus consequat.</p>
        <br>
        <p>Curabitur aliquet massa sed porttitor varius. Mauris odio ligula, posuere euismod sodales ac, convallis at felis. Nullam et diam mattis, rutrum nulla non, lacinia tellus. Nulla facilisi. Suspendisse mattis, purus et malesuada bibendum, sem ligula luctus leo, et ultricies metus erat dignissim nisi. Suspendisse potenti. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc in placerat est. Aliquam accumsan tincidunt dignissim. Curabitur a egestas tortor.</p>
        <br>
        <p>Duis eu eleifend nulla, a dignissim lacus. Aliquam laoreet nisl tellus, in sodales nibh fermentum a. Phasellus tortor turpis, aliquet sed lorem eget, vehicula dignissim dolor. Morbi efficitur leo quis auctor aliquam. Morbi pellentesque libero sit amet nunc varius, eget laoreet justo vestibulum. Mauris eget egestas sapien. Sed varius semper metus nec varius. Duis sagittis turpis magna, vel dapibus turpis tempus id.</p>
    </div>
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <br>
    <!-- ---- -->
    <hr><br>
    <h2>Norite tapti pacientu?</h2>
    <p>Paskambinkite: +370 123 456 78</p>

</body>
</html>
