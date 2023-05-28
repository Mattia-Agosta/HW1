<?php
    /****************************************************
     Questa pagina verifica se un utente ha aggiunto o meno un
     determinato gioco ai preferiti 
     ****************************************************/
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione o non è stato passato un parametro, me ne vado
     if(!isset($_SESSION['user_id']) || !isset($_GET["game_id"])) {
         exit;
    }

    Header('Content-Type: application/json');

    $conn = mysqli_connect($dbdata['host'], $dbdata["user"], $dbdata["password"], $dbdata["name"]) 
    or die (mysqli_error($conn));
    $game_id = mysqli_real_escape_string($conn, $_GET["game_id"]);
    $user = $_SESSION["user_id"];

    //Dopo aver stabilito la connessione col database, verifico se il gioco è tra i preferiti dell'utente
    $query = "SELECT * FROM likes WHERE user_id = '$user' AND game_id = '$game_id'";
    $res = mysqli_query($conn, $query);
    if (mysqli_fetch_row($res)) {
        //Se viene restitito un risultato, l'utente ha quel gioco tra i preferiti
        $return = array();
        $return["value"] = "LIKE"; 
        $return["n"] = $_GET["game_number"];
        mysqli_free_result($res);
        mysqli_close($conn);
        echo json_encode($return);
        exit;
    } else {
        //L'utente non ha quel gioco tra i preferiti
        $return = array();
        $return["value"] = "UNLIKE"; 
        $return["n"] = $_GET["game_number"];
        mysqli_free_result($res);
        mysqli_close($conn);
        echo json_encode($return);
        exit;
    }

?>