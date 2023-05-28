<!------------------------------------------------------------------- 
    Questa pagina rappresenta la home del sito, da cui è possibile
      - Effettuare il log-out;
      - Accedere alle altre pagine del sito (tra cui il proprio profilo);
      - Visualizzare alcuni giochi casualmente estratti da un database;
      - Visualizzare il pokemon del giorno (grazie a PokeAPI);
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
        <title> Mattia's Games </title>
        <link rel = "stylesheet" href = "styles/home.css">
        <script src = "home.js" defer></script>
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
            <section id = "s1">
                <!-- Questa sezione conterrà i giochi consigliati -->
                <h3>Non sai a cosa giocare? Ecco alcuni consigli!</h3>
                <div id = "container">
                    <img id = "waiting" src = "images/waiting.gif">
                </div>
            </section>
            <section id = "s2">
                <!-- Questa sezione permetterà di accedere alle altre pagine del sito -->
                <div id = "search">
                    <div id = "searchGame">
                        <h3>Cerca un gioco nel database di RAWG!</h3>
                        <!-- Di fatto vieni idirizzato alla pagina di ricerca, ma passando
                        ciò che scrivi come richiesta POST -->
                        <form action = "search.php" method = "POST"> 
                            <input type = 'text' name = "search" id = "searchBar" 
                            autocomplete = "off" placeholder = "Titolo" >
                            <input type = "submit" value = "Cerca" class = "searchSubmit">
                        </form>
                    </div>
                    <div id = "latestGames">
                        <h3>Scopri gli ultimi giochi rilasciati!</h3>
                        <!-- Di fatto vieni indirizzato alla pagina che mostra gli ultimi 
                        giochi usciti, ma passando la tua scelta come richiesta POST -->
                        <form action = "latest_games.php" method = "POST"> 
                            <select name = "platform" id = "platform" required>
                                <option value = "all">Tutte le piattaforme</option>
                                <option value = "PC">PC</option>
                                <option value = "PS4">PlayStation 4</option>
                                <option value = "PS5">PlayStation 5</option>
                                <option value = "Switch">Nintendo Switch</option>
                                <option value = "Xbox One"> Xbox One </option>
                                <option value = "Xbox Series">Xbox Series</option>
                            </select>
                            <input type = "submit" value = "Vai" class = "searchSubmit">
                        </form>
                    </div>
                </div>
                <div id = "topGames">
                    <a href = "top_games.php">
                        Clicca qui per scoprire i 10 giochi più apprezzati!
                    </a>
                </div>
            </section>
            <section id = "s3">
                <!-- Questa sezione conterrà il Pokèmon del giorno
                    Il contenuto è di fatto interamente gestito da Javascript -->
                <h3 id = "pokeTitle"></h3>
                <div id = "pokeContent">
                    <div id = "pokeIMG"></div>
                    <div id = "pokeData"></div>
                </div>
            </section>
            <div id ="back">
                <a href = "#">Torna su</a>
            </div>
        </main>
    </body>
</html>