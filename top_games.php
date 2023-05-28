<?php
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
    if(!isset($_SESSION['user_id'])) {
         header("Location: index.php");
         exit;
    }
?>

<!-------------------------------------------------------------------
    Questa pagina permette di visualizzare i 10 giochi più apprezzati
    e cioè quelli che sono stati inseriti nei preferiti da più utenti
--------------------------------------------------------------------->
<html>
    <head>
        <title> Top 10 giochi </title>
        <link rel = "stylesheet" href = "styles/top_games.css">
        <script src = "top_games.js" defer></script>
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
            <h2>I 10 giochi più apprezzati dagli utenti di questo sito!</h2>
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