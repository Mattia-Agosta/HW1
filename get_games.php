<?php 
/*******************************************************
   Gestisce RAWGAPI restituendo il json 
   della ricerca effettuata 
   RAWG API KEY: 5a51c4d19b7e48ffb31b158715a0d94c
********************************************************/

    session_start();                //Dò il via alla sessione
    // Se non esiste già una sessione o se non è stato passato un parametro me ne vado
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
    if (!isset($_GET["q"]) && !isset($_GET["p"])) {
        header("Location: home.php");
        exit;
    }

    // Imposto l'header della risposta
    header('Content-Type: application/json'); 

    //Preparo la richiesta con curl
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $key = "5a51c4d19b7e48ffb31b158715a0d94c";
    if(isset($_GET["q"])) {
        //Se ho passato il parametro q, sto facendo una ricerca per titolo
        //Con un ciclo, restituisco la pagina corrispondente
        $i = 1;
        while ($i < $_GET["page"]) {
            $i++;
        }
        $url = "https://api.rawg.io/api/games?key=" . $key . "&search=" . $_GET["q"] . "&ordering=-rating&search_precise=yes&page_size=9&page=" . $i;
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        echo $res;
        exit;
    } else {
        //Se ho passato il parametro p, sto cercando gli ultimi giochi rilasciati.
        //Imposto come range di data l'ultimo anno, per evitare che mi vengano
        //restituiti giochi che debbono ancora uscire
        $data1 = new DateTime();      //Ottengo la data di oggi
        //Clono la prima data
        $data2 = clone $data1;
        //Modifico la seconda data, trasformandola in quella di un anno fa
        $data2 = date_modify($data2, "-1 year");
        //Imposto il formato che mi serve 
        $data1 = date_format($data1, "Y-m-d");
        $data2 = date_format($data2, "Y-m-d");
        switch ($_GET["p"]) {
            //Tramite uno switch, distinguo tutti i casi possibili
            //Codici piattaforme:
            //PC = 4 | PS4 = 18 | PS5 = 187 | Switch = 7 | Xbox Series = 186 | Xbox One = 1
            case "all":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=4,18,187,7,186&dates=" . $data2 . "," . $data1 . "&ordering=-released";
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "PS4":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=18&dates=" . $data2 . "," . $data1 . "&ordering=-released";
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "PC":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=4&dates=" . $data2 . "," . $data1 . "&ordering=-released";
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "PS5":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=187&dates=" . $data2 . "," . $data1 . "&ordering=-released";                
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "Switch":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=7&dates=" . $data2 . "," . $data1 . "&ordering=-released";                
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "Xbox Series":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=186&dates=" . $data2 . "," . $data1 . "&ordering=-released";                
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            case "Xbox One":
                $url = "https://api.rawg.io/api/games?key=" . $key . "&platforms=1&dates=" . $data2 . "," . $data1 . "&ordering=-released";                
                curl_setopt($curl, CURLOPT_URL, $url);
                $res = curl_exec($curl);
                curl_close($curl);
                echo $res;
                break;
            default:
                break;
        }
        exit;
    }
?>