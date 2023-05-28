<!------------------------------------------------------------------- 
    Questa pagina rappresenta il profilo dell'utente, dove è possibile
    vedere la lista dei giochi preferiti
----------------------------------------------------------------------->

<?php
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
     if(!isset($_SESSION['user_id'])) {
         header("Location: index.php");
         exit;
    }
?>

<html>
    <head>
        <title> Profilo di <?php
            echo $_SESSION["username"];
            ?> </title>
        <link rel = "stylesheet" href = "styles/profile.css">
        <script src = "profile.js" defer></script>
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
                <a href = "delete.php">
                    <button id = "delete"> Elimina </button> 
                    <img src = "images/logos/delete.png" id = "delete">
                </a>
                <a href = "logout.php">    
                    <button id = "logout"> Log-out </button> 
                    <img src = "images/logos/logout.png" id = "logout">
                </a>
            </div>
        </header>
        <main>  
            <section>
                <!-- L'unica sezione conterrà la lista dei giochi 
                preferiti dall'utente -->
                <h3>Benvenuto, <?php
                    echo $_SESSION["username"];
                    ?>! <br> Ecco i giochi che hai aggiunto ai preferiti</h3>
                <div id = "container">
                    <img id = "waiting" src = "images/waiting.gif">
                </div>
                <div id = "pageContainer"></div>
            </section>
            <div id ="links">
            <div> 
                <a href = "#">Torna su</a>
            </div>
            <div>
                <a href = "home.php">Torna alla home</a>
            </div>
        </div>
        </main>
    </body>
</html>