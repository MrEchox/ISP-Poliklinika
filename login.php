<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
if(isset($_POST["submit"])){
    $loginname = $_POST["email"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$loginname'");// OR TelefonoNr = '$loginname'");
    $row = mysqli_fetch_assoc($result);
    
    if(mysqli_num_rows($result) > 0){
        if($password == $row["Slaptazodis"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["EPastas"];
            header("Location: index.php");
        }
        else{
            echo "<script>alert('Neteisingas slaptažodis')</script>";
        }
    }
    else{
        echo "<script>alert('E-paštas neegzistuoja')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungimas</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <a class="logo"><img src="LOGO.png" alt="Logo" width="44" height="32"></a>
        <a href="index.php">Pradžia</a>
        <a href="info.php">Informacija</a>
    </div>

    <!-- Forma -->
    <h2>Prisijungimas</h2> 
    <form action="" method="post">
        <label for="email">El-paštas:</label>
        <input type="email" id="email" name="email" class="inputfield" required>
        <br><br>

        <label for="password">Slaptažodis:</label>
        <input type="password" id="password" name="password" class="inputfield" required>
        <br><br>

        <button type="submit" name="submit">Prisijungti</button>
        <br><br>

        <p>Kurti naują paskyrą?</p>
        <a href="register.php">Registruotis</a>
    </form>

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
</body>
</html>
