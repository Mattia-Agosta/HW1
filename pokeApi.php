<?php 
/*******************************************************
   Gestisce PokeAPI restituendo il json del pokèmon del giorno

********************************************************/

session_start();                //Dò il via alla sessione
// Se non esiste già una sessione o se non è stato passsato un parametro me ne vado
if(!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
} 
if (!isset($_GET["q"])) {
    header("Location: home.php");
    exit;
}

// Imposto l'header della risposta
header('Content-Type: application/json');

pokeApi(); 

function pokeApi () {
    //Preparo la richiesta con curl
    $curl = curl_init();
    $url = "https://pokeapi.co/api/v2/pokemon/" . $_GET["q"];
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($curl);
    curl_close($curl);
    echo $res;
}
?>