<!DOCTYPE html>
<html>
<head>
    <title>Pradžia</title>
    <link rel="stylesheet" href="../stylesheet.css">
    <link rel="stylesheet" href="gydytojas.css">
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <a class="logo"><img src="../LOGO.png" alt="Logo" width="44" height="32"></a>
        <a href="../home.html">Pradžia</a>
        <a href="../info.html">Informacija</a>
        <a href="gydytojas.html">Pagrindinė informacija</a>
        <a href="vaistas.html">Išrašyti vaistą</a>
        <a href="siuntimas.html">Siuntimas</a>
        <a class="right" href="profile.html">Asmeninė informacija</a>
    </div>

    <div class="siuntimas">
        <h2>Kurti naują siuntimą</h2>
        <form action="kurti_ataskaia.php" method="POST" class="formaSiuntimo"> <!-- Change action into smt that actually does smt-->
            <label for="text">Pacientas:</label>
            <select class="inputfield">
                <option value="default" >Pasirinkite pacientą</option>
                <option value="1" >Jonas Jonauskas</option>
                <option value="2">Petras Petrauskas</option>
            </select>
        
            <label for="text">Aprašymas:</label>
            <select class="inputfield">
                <option value="default" >Pasirinkite daktarą</option>
                <option value="1" >Chirurgas</option>
                <option value="2">Okulistas</option>
                <option value="3">Kardiologas</option>
                <option value="4">Ortopedas</option>
            </select>
    
            <input type="submit" value="Įrašyti">
            <br><br>
        </form>
    </div>
    

    <footer>
        <p font-size="14px">@KTU Informatikos Fakultetas | Informacinių sistemų pagrindai</p>
    </footer>
    <br>
    <!-- ---- -->

</body>
</html>
