<?php

    /*****************************************************
     Questa pagina verifica se un' e-mail è presente o meno 
     nel database
    ******************************************************/
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    if(!isset($_GET["q"])) {        //Se la pagina dovesse essere aperta per metodi illeggittimi
        echo "Non dovresti essere qui!";
        exit;
    }
    header ("Content-type: application/json");

    $conn = mysqli_connect($dbdata['host'], $dbdata['user'], $dbdata['password'], $dbdata['name'])
            or die (mysqli_error($conn));
    $mail = mysqli_real_escape_string($conn, $_GET["q"]);
    $query = "SELECT * FROM users WHERE mail = '$mail'";
    $res = mysqli_query($conn, $query) or die (mysqli_error($conn));
    //Costruisco un array associativo per tornare il risultato della query:
    //Se esiste l'username nel database ritorno 1, altrimenti 0
    if(mysqli_num_rows($res) > 0) {
        $ret = array('exists' => 1);
    } else {
        $ret = array('exists' => 0);
    }
    $ret = json_encode($ret);
    mysqli_free_result($res);
    mysqli_close($conn);
    echo $ret;
    
?>