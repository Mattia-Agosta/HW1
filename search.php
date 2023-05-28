<?php
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
    if(!isset($_SESSION['user_id'])) {
         header("Location: index.php");
         exit;
    }
?>

<!-------------------------------------------------------------------
    Questa pagina permette di effettuare delle ricerche tramite l'API
    di RAWG e visualizzare fino a 9 risultati
--------------------------------------------------------------------->
<html>
    <head>
        <title> Cerca giochi </title>
        <link rel = "stylesheet" href = "styles/search.css">
        <script src = "search.js" defer></script>
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
            <h2>Cerca un gioco nel database di RAWG!</h2>
            <form method = "POST"> 
                <!-- Se accedo alla pagina dalla home cercando qualcosa, 
                quel che ho cercato viene inserito nel campo -->
                <input type='text' name="search" id="searchBar" autocomplete="off" 
                    placeholder="Titolo" <?php 
                    if(isset($_POST["search"])){
                        echo "value = ".$_POST["search"];} ?> >
                    <input type="submit" value="Cerca" id = "searchSubmit">
            </form>
            <div id = "container"></div>
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