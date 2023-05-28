
<!--------------------------------------------------------------
Pagina tramite la quale è possibile effettuare il log-in   
---------------------------------------------------------------->

<?php 
    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se esiste già una sessione vado alla home
    if(isset($_SESSION['user_id'])) {
        header("Location: home.php");
        exit;
    }

    //Verifico l'esistenza di dati POST e cioè se l'utente ha provato a fare il login
    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        //Se sono stati inseriti entrambi i valori
        $errore = array();
        $conn = mysqli_connect($dbdata['host'], $dbdata['user'], $dbdata['password'], $dbdata['name'])
        or die (mysqli_error($conn));
        
        # VERIFICA USERNAME
        //Verifico se il nome utente è presente nel database
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            //Se è stato tornato un risultato, significa che l'utente esiste. Posso procedere

            # CONTROLLO PASSWORD
            //Devo verificare se è stata inserita la password corretta
            $entry = mysqli_fetch_assoc($res);
            $password = $_POST["password"];
            if (password_verify($password, $entry["password"])) {
                //Le password coincidono: dò il via alla sessione e accedo
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["user_id"] = $entry["id"];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            } else {
                //Le password non coincidono
                $errore[] = "Credenziali non valide";
            }
        } else {
            //Non è stato trovato nessun risultato
            $errore[] = "Credenziali non valide";
        }
        mysqli_free_result($res);
    } else if (isset($_POST["username"]) || isset($_POST["password"])) {
        //Se è stato inserito un solo valore
        $errore = array ("Inserire username e password");
    }
?>
<html>
    <head>
        <title> Accedi a Mattia's Games </title>
        <link rel = "stylesheet" href = "styles/login.css">
        <script src = "login.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <header id = "title">                
            <a href = "index.php"> 
                <img src = "images/logo.png">
            </a>
            <h1>Mattia's Games</h1>
        </header>
        <section>
            <h2>Accedi al tuo profilo</h2>
            <form name = "login" method = "post" enctype="multipart/form-data">
                <div>
                    <span> Username: </span>
                    <div>
                        <div class = "form_item">
                            <img src = "images/logos/username.png">
                            <input type = "text" name = "username" id = "input_username">
                        </div>
                        <p class = "errorp"> </p>
                    </div>
                </div>
                <div>
                    <span> Password: </span>
                    <div class = "form_item">
                        <img src = "images/logos/password.png">
                        <input type = "password" name = "password" id = "input_password">
                    </div>
                </div>
                <!-- Se si è verificato errore, stampo i messaggi -->
                <?php if(isset($errore)) {
                    foreach($errore as $err) {
                        echo "<div class='errorphp'>
                        <img src='images/logos/error.png'/>
                            <p>".$err."</p>
                        </div>";
                    }
                } ?>
                <div id = "conferma">
                    <input type = "submit" value = "Accedi" id = "submitbtn">
                </div>
                <p> Non hai un account? 
                    <a href = "register.php"> Registrati </a>
                </p>
            </form>
        </section>
    </body>  
</html>