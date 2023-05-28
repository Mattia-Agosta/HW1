<!-----------------------------------------------------------------------------
    Questa è la pagina iniziale, tramite la quale è possibile 
    accedere alla pagina di log-in oppure a quella per registrarsi al sito
------------------------------------------------------------------------------>
<?php
    session_start();                //Dò il via alla sessione
    // Se esiste già una sessione vado alla home
     if(isset($_SESSION['user_id'])) {
         header("Location: home.php");
         exit;
    }
?>

<html>
    <head>
        <title> Mattia's Games </title>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
        <link rel = "stylesheet" href = "styles/index.css">
    </head>
    <body>
        <header> 
            <div id = "title">
                <img src = "images/logo.png">
                <h1>Mattia's games </h1>
            </div>
            <span> Il posto dove gli appassionati di videogiochi si riuniscono </span>
            <p>Effettua una ricerca nel nostro databese, visualizza gli ultimi videogiochi usciti sul mercato, 
                salva i preferiti nel tuo profilo. The game is on!
            </p> 
        </header>
        <section>
            <a href = "register.php"> 
                <button class="button"> Registrati </button> 
            </a>
            <a href = "login.php"> 
                <button class="button"> Accedi </button>
            </a>
            </button>
        </section>
    </body>
</html>
