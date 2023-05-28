<?php
    /****************************************************
     Questa pagina restituisce tutti i giochi che un utente
     ha aggiunto ai preferiti, ordinata in base al numero di 
     utenti che hanno aggiunto quel gioco ai preferiti
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

    $query = "SELECT * FROM likedGames ORDER BY n_likes DESC";
    $res = mysqli_query($conn, $query);
    $games = array();
    while ($game = mysqli_fetch_assoc($res)) {
        //copio i risultati in un array, che poi convertirò in json e restituirò
        $games[] = $game;
    }
    echo json_encode($games);

?>