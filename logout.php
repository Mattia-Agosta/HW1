<?php

/*******************************************
 Questa pagina gestisce il log-out dal sito
 *******************************************/

    session_start();    //Mi connetto alla sessione attuale
    session_destroy();  //Distruggo la sessione attuale
    header ('Location: index.php'); //Re-indirizzo alla pagina inizale
?>