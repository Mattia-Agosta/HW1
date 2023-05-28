<?php
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
    if(!isset($_SESSION['user_id'])) {
         header("Location: index.php");
         exit;
    }
?>

<!-------------------------------------------------------------------
    Questa pagina permette di visualizzare gli ultimi giochi usciti per 
    una determinata piattaforma, tramite l'API di RAWG, e ne visualizza
    fino a 9
--------------------------------------------------------------------->


<html>
    <head>
        <title> Ultime uscite </title>
        <link rel = "stylesheet" href = "styles/latest_games.css">
        <script src = "latest_games.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <header>
            <div id = "title">                
                <a href = "home.php"> 
                    <img src = "images/logo.png">
                </a>
                <h1>Mattia's Games</h1>
            </div>
            <div id = "buttons">
                <a href = "profile.php">
                    <button id = "profilo"> Profilo </button> 
                    <img src = "images/logos/username.png" id = "profilo">
                </a>
                <a href = "logout.php">    
                    <button id = "logout"> Log-out </button> 
                    <img src = "images/logos/logout.png" id = "logout">
                </a>
            </div>
        </header>
        <main>
            <h2>Scopri gli ultimi videogiochi rilasciati</h2>
            <form method = "POST"> 
                <select name = "platform" id = "platform" required>
                    <!-- Se accedo dalla home, riporto la selezione che avevo fatto -->
                    <option value = "all" <?php 
                    if($_POST["platform"] == "all"){
                        echo "selected";} ?>>Tutte le piattaforme</option>
                    <option value = "PC" <?php 
                    if($_POST["platform"] == "PX"){
                        echo "selected";} ?>>PC</option>
                    <option value = "PS4" <?php 
                    if($_POST["platform"] == "PS4"){
                        echo "selected";} ?>>PlayStation 4</option>
                    <option value = "PS5" <?php 
                    if($_POST["platform"] == "PS5"){
                        echo "selected";} ?>>PlayStation 5</option>
                    <option value = "Switch" <?php 
                    if($_POST["platform"] == "Switch"){
                        echo "selected";} ?>>Nintendo Switch</option>
                    <option value = "Xbox One" <?php 
                    if($_POST["platform"] == "Xbox One"){
                        echo "selected";} ?>>Xbox One</option>
                    <option value = "Xbox Series" <?php 
                    if($_POST["platform"] == "Xbox"){
                        echo "selected";} ?>>Xbox Series</option>
                </select>
                <input type = "submit" value = "Vai" id = "searchSubmit">
            </form>
            <div id = "container">
                <img id = "waiting" src = "images/waiting.gif">
            </div>
        </main>
        <div id ="links">
            <div> 
                <a href = "#">Torna su</a>
            </div>
            <div>
                <a href = "home.php">Torna alla home</a>
            </div>
        </div>
    </body>
</html> 