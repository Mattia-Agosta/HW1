<?php 
/*******************************************************
   Restituisce 5 giochi estrati a caso da un database 
   compilato manualmente
********************************************************/

    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione me ne vado
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Imposto l'header della risposta
    header('Content-Type: application/json');

    $conn = mysqli_connect($dbdata['host'], $dbdata["user"], $dbdata["password"], $dbdata["name"]) 
    or die (mysqli_error($conn));
    //Vedo quanti giochi ho nel database 
    $query = "SELECT * FROM myGames";
    $res = mysqli_query($conn, $query);
    $tot = 0;
    while (mysqli_fetch_assoc($res)) {
        $tot++;
    }
    //Come prima cosa ho bisogno di generare 5 numeri casuali diversi: serviranno a selezionare i giochi.
    //Ci riesco creando un array e mescolandolo, per poi selezionare solo la parte che mi interessa
    $numbers = range(1, $tot);
    $length = 5;
    shuffle($numbers);
    $numbers = array_slice ($numbers, 0, $length);
    $games = array();
    //Adesso uso i numeri ottenuti per estrarre dal database i giochi corrispondenti
    for ($i = 0; $i < $length; $i++) {
        $query = "SELECT * FROM myGames WHERE id = " . $numbers[$i];
        $res = mysqli_query($conn, $query);
        $games[] = mysqli_fetch_assoc($res);
        mysqli_free_result($res);
    }
    mysqli_close($conn);
    //Restituisco il risultato sotto forma di json
    echo json_encode($games);
?>