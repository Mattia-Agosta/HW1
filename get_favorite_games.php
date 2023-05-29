<?php
    /****************************************************
     Questa pagina restituisce tutti i giochi cui l'utente
     attualmente connesso ha aggiunto tra i preferiti
     ****************************************************/
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
     if(!isset($_SESSION['user_id'])) {
         exit;
    }

    Header('Content-Type: application/json');

    $conn = mysqli_connect($dbdata['host'], $dbdata["user"], $dbdata["password"], $dbdata["name"]) 
    or die (mysqli_error($conn));
    $user = $_SESSION["user_id"];

    //Dopo aver stabilito la connessione col database, restituisco i giochi dell'utente
    //per fare ciò, è necessario un JOIN tra le due tabelle, in modo da restituire anche i dati
    //necessari a "ricostruire" il gioco
    $query = "SELECT * FROM likedGames JOIN likes on likes.game_id = likedGames.game_id WHERE likes.user_id = '$user'";
    $res = mysqli_query($conn, $query);
    $games = array();
    while ($game = mysqli_fetch_assoc($res)) {
        //copio i risultati in un array, che poi convertirò in json e restituirò
        $games[] = $game;
    }
    mysqli_close($conn);
    //Dopo aver ottenuto tutti i giochi, prendo solo quelli della pagina corrente
    $page = $_GET["page"];
    $inizio = ($page - 1) * 9;
    $games = array_slice($games, $inizio, 9);
    echo json_encode($games);

?>