<?php
    /****************************************************
     Questa pagina si occupa di aggiungere o rimuovere dai
     preferiti di un utente un gioco, intervenendo sul database.
     Utilizzo due tabelle:
     - LikedGames, che conserva tutte le informazioni sui giochi messi 
        tra i preferiti, e quanti utenti li hanno aggiunti;
     - Likes, classica tabella intermedia che conserva i preferiti di ogni 
        utente;
     ****************************************************/
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione o se non sono stati passati tutti i parametri me ne vado
    if(!isset($_SESSION['user_id']) || !isset($_GET["game_id"]) || !isset($_GET["azione"])) {
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbdata['host'], $dbdata["user"], $dbdata["password"], $dbdata["name"]) 
    or die (mysqli_error($conn));
    $game_id = mysqli_real_escape_string($conn, $_GET["game_id"]);
    $user = $_SESSION["user_id"];
    //Come prima cosa, dopo aver stabilito la connessione col database,
    //verifico se devo AGGIUNGERE o RIMUOVERE dai preferiti
    if ($_GET["azione"] == "like") {
        //Voglio AGGIUNGERE il gioco ai preferiti
        //Verifico se il gioco esiste già nella tabella likedGames
        $query = "SELECT * FROM likedGames WHERE game_id = '$game_id'";
        $res = mysqli_query($conn, $query);
        if(!mysqli_fetch_row($res)) {
            //Se non è stato trovato il gioco, devo aggiungerlo
            $titolo = mysqli_real_escape_string($conn, $_GET["titolo"]);
            $img =  mysqli_real_escape_string($conn, $_GET["img"]);
            $genere = mysqli_real_escape_string($conn, $_GET["genere"]);
            $data = mysqli_real_escape_string($conn, $_GET["data"]);
            $piattaforme = mysqli_real_escape_string($conn, $_GET["piattaforme"]);
            $query = "INSERT INTO likedGames (game_id, titolo, img, genere, data, piattaforme)
             VALUES ('$game_id', '$titolo', '$img', '$genere', '$data', '$piattaforme')";
            mysqli_query($conn, $query);
        }
        //Procedo ad aggiornare la tabella likes e ad incrementare n_likes in likedGames
        mysqli_free_result($res);
        //Aggiorno la tabella likes
        $query = "INSERT IGNORE INTO likes VALUES ('$user', '$game_id')";
        mysqli_query($conn, $query);
        //Incremento n_likes
        $query = "UPDATE likedGames SET n_likes = n_likes + 1 WHERE game_id = '$game_id'";
        mysqli_query($conn, $query);
        //Azione completata, posso uscire
    } else {
        //Voglio RIMUOVERE il gioco dai preferiti
        //Questa volta, prima rimuovo dalla tabella likes e decremento n_likes
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
        //Azione completata, posso uscire
    }
    mysqli_close($conn);
    $return = array ();
    $return["gioco"] = $game_id;
    if(isset($_GET["titolo"])) {
        $return["titolo"] = $_GET["titolo"];
    }
    $return["azione"] = $_GET["azione"];
    $return["utente"] = $user;
    $return["esito"] = "ok";
    echo json_encode($return);
?>