<?php
    /****************************************************
     Questa pagina elimina l'account di un utente e tutte 
     le sue informazioni negli altri database
     ****************************************************/
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione o non è stato passato un parametro, me ne vado
     if(!isset($_SESSION['user_id'])) {
         header("Location: index.php");
         exit;
     }

    $conn = mysqli_connect($dbdata['host'], $dbdata["user"], $dbdata["password"], $dbdata["name"]) 
    or die (mysqli_error($conn));
    $user = $_SESSION["user_id"];
    //Come prima cosa, elimino tutti i giochi che l'utente ha aggiunto ai preferiti
    //Prima, trovo tutti i giochi che l'utente ha aggiunto ai preferiti
    $query = "SELECT game_id FROM likes WHERE user_id = '$user'";
    $res = mysqli_query($conn, $query);
    $games = array();
    while ($game = mysqli_fetch_row($res)) {
        $games[] = $game[0];
    }
    //Adesso rimuovo tutti i giochi che ho trovato
    mysqli_free_result($res);
    $i = 0;
    while ($games[$i]) {
        $game_id = $games[$i];
        $query = "DELETE FROM likes WHERE game_id = '$game_id' AND user_id = '$user'";
        mysqli_query($conn, $query);
        $query = "UPDATE likedGames SET n_likes = n_likes - 1 WHERE game_id = '$game_id'";
        mysqli_query($conn, $query);
        //Se il gioco adesso ha zero like, lo rimuovo dalla tabella
        $query = "SELECT n_likes FROM likedGames WHERE game_id = '$game_id'";
        $res = mysqli_query($conn, $query);
        if(mysqli_fetch_row($res)[0] == 0) {
            $query = "DELETE FROM likedGames WHERE game_id = '$game_id'";
            mysqli_query($conn, $query);
        }
        mysqli_free_result($res);
        $i++;
    }
    //Adesso posso procedee alla rimozione del profilo
    $query = "DELETE FROM users WHERE id = '$user'";
    mysqli_query($conn, $query);
    //Elimino infine la sessione
    session_destroy();  //Distruggo la sessione attuale
    header ('Location: index.php'); //Re-indirizzo alla pagina inizale
?>