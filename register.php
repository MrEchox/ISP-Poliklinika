<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
if(isset($_POST["submit"])){
    $name = $_POST["first_name"];
    $lastname = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    $dublicate = mysqli_query($conn, "SELECT * FROM naudotojas WHERE EPastas = '$email'");

    if(mysqli_num_rows($dublicate) > 0){
        echo "<script>alert('Šis E-paštas jau užimtas')</script>";
    }
    else{
        if($password == $confirm_password){
            $query = "INSERT INTO naudotojas VALUES('$name', '$lastname', '$email', '$phone', '$password', 'Svecias')";
            mysqli_query($conn,$query);
            echo "<script>alert('Sėkmingai užsiregistravote')</script>";
            //header("Location: login.php");
        }
        else{
            echo "<script>alert('Slaptažodžiai nesutampa')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <a class="logo"><img src="LOGO.png" alt="Logo" width="44" height="32"></a>
        <a href="index.php">Pradžia</a>
        <a href="info.php">Informacija</a>
    </div>

    <h2>Registracija</h2> 
    <form action="" method="post">
        <label for="email">El-paštas:</label>
        <input type="email" id="email" name="email" class="inputfield" required>
        <br><br>

        <label for="phone">Telefono nr.:</label>
        <input type="tel" id="phone" name="phone" class="inputfield" required>
        <br><br>

        <label for="password">Slaptažodis:</label>
        <input type="password" id="password" name="password" class="inputfield" required>
        <br><br>

        <label for="confirm_password">Pakartokite slaptažodį:</label>
        <input type="password" id="confirm_password" name="confirm_password" class="inputfield" required>
        <br><br>

        <label for="first_name">Vardas:</label>
        <input type="text" id="first_name" name="first_name" class="inputfield" required>
        <br><br>

        <label for="last_name">Pavardė:</label>
        <input type="text" id="last_name" name="last_name" class="inputfield" required>
        <br><br>

        <label for="dob">Gimimo data:</label>
        <input type="date" id="dob" name="dob" class="inputfield" required>
        <br><br>

        <label for="gender">Lytis:</label>
        <select id="gender" name="gender" class="inputfield" required>
            <option value="male">Vyras</option>
            <option value="female">Moteris</option>
            <option value="other">Kita</option>
        </select>
        <br><br>

        <button type="submit" name="submit">Registruotis</button>
        <br><br>

        <p>Turite paskyrą?</p>
        <a href="login.php">Prisijunkite</a>
    </form>
    
    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <br>
</body>
</html>
