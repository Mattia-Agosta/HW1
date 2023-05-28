<!--------------------------------------------------------------
Pagina tramite la quale è possibile registrarsi sul sito   
---------------------------------------------------------------->
<?php

    require_once "db_data.php";      //Importo il file contenente le credenziali del database
    session_start();                //Dò il via alla sessione
    // Se esiste già una sessione vado alla home
    if(isset($_SESSION['user_id'])) {
            header("Location: home.php");
            exit;
    }

    //Verifico l'esistenza di dati POST e cioè se il form è stato compilato per intero
    if(!empty($_POST["nome"]) && !empty($_POST["cognome"]) && !empty($_POST["username"])
        && !empty($_POST["mail"]) && !empty($_POST["password"]) && !empty($_POST["password2"])) {
            //Se sono qui dentro, sicuramente sono stati compilati tutti i campi. Ne verifico la correttezza
            $errore = array();
            $conn = mysqli_connect($dbdata['host'], $dbdata['user'], $dbdata['password'], $dbdata['name'])
            or die (mysqli_error($conn));
            
            # VERIFICA USERNAME (Nome e cognome non hanno bisogno di verifiche)
            //Controllo che non utilizzi caratteri illegali
            if (!(preg_match('/^[a-z\d_]{2,20}$/i', $_POST["username"]))) {
                $errore[] = "Username non valido!";
            } else if (strlen($_POST["username"]) > 20) {
                $errore[] = "Username troppo lungo!";
            }
            //Controllo superato
            else {
                $username = mysqli_real_escape_string($conn, $_POST["username"]);
                //Verifico se l'username esiste già
                $query = "SELECT * FROM users WHERE username = '$username'";
                $res = mysqli_query($conn, $query);
                if (mysqli_num_rows($res) > 0) {
                    $errore[] = "Username già utilizzato";
                }
                mysqli_free_result($res);
            }
            //Verifica username terminata
            
            #VERIFICA E-MAIL
            //Controllo che il formato sia corretto
            if ((!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))) {
              $errore[] = "E-mail non valida!";
            }
            //Controlllo superato
            else {
                $mail = mysqli_real_escape_string($conn, $_POST["mail"]);
                //Verifico se la mail esiste già - non ha senso avere due account con la stessa mail
                $query = "SELECT * FROM users WHERE mail = '$mail'";
                $res = mysqli_query($conn, $query);
                if (mysqli_num_rows($res) > 0) {
                    $errore[] = "E-mail già utilizzata";
                }
                mysqli_free_result($res);
            }
            //Verifica e-mail terminata

            #VERIFICA PASSWORD
            //Controllo che il formato sia corretto (almeno 8 caratteri, almeno 1 maiuscola, almeno 1 numero)
            $password = $_POST["password"];
            $uc = preg_match('@[A-Z]@', $password);
            $lc = preg_match('@[a-z]@', $password);
            $num = preg_match('@[0-9]@', $password);
            if (strlen($password) < 8) {
                $errore[] = "Password troppo corta";
            } else if (!$uc || !$lc || !$num || strlen($password) < 8) {
                $errore[] = "Password non sicura!";
            }
            //Controllo superato

            //Verifico che le due password coincidano
            $password2 = $_POST["password2"];
            if (strcmp ($password, $password2)) {
            $errore[] = "Le password non coincidono!";
            }
            //Verifica password terminata

            #VERIFICA TCU
            //Controllo che l'utente abbia verificato i termini e le condizioni d'uso
            if (empty($_POST["tcu"])) {
                $errore [] = "Accettare i termini e le condizioni d'uso";
            }
            //Controllo superato

            #INSERIMENTO NEL DATABASE
            //A questo punto, se non sono stati trovati errori, posso registrare l'utente
            if (!$errore) {
                $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
                $cognome = mysqli_real_escape_string($conn, $_POST["cognome"]);
                $password = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO users (nome, cognome, username, mail, password)
                VALUES ('$nome', '$cognome', '$username', '$mail', '$password')";
                if (mysqli_query($conn, $query)) {
                    //Se la registrazione è andata a buon fine, inizio la sessione dell'utente
                    $_SESSION["username"] = $_POST["username"];
                    $_SESSION["user_id"] = mysqli_insert_id($conn);
                    mysqli_close($conn);
                    header("Location: home.php");
                    exit;
                } else {
                    $error[] = "Errore di connessione al Database";
                }
            } 
        } else if (isset($_POST["username"])) {
            $errore = array ("Riempire tutti i campi");
        }
?>

<html>
    <head>
        <title> Registrazione a Mattia's Games </title>
        <link rel = "stylesheet" href = "styles/register.css">
        <script src = "register.js" defer></script>
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
            <h2>Registrati per avere accesso al nostro vasto database</h2>
            <form name = "register" method = "post" enctype="multipart/form-data">
                <!-- Il form è strutturato in modo che, se la pagina viene ricaricata e 
                la registrazione non a buon fine, vengano mantenuti i valori precedentemente inseriti -->
                <div>
                    <span> Nome: </span>
                    <div class = "form_element">
                        <img src = "images/logos/name_surname.png">
                        <input type = "text" name = "nome" id = "input_nome" <?php 
                            if(isset($_POST["nome"])){
                                echo "value = ".$_POST["nome"];} ?> >
                    </div>
                    <p class = "errorp"></p>
                </div>
                <div>
                    <span> Cognome: </span>
                    <div class = "form_element">
                        <img src = "images/logos/name_surname.png">
                        <input type = "text" name = "cognome" id = "input_cognome" <?php 
                            if(isset($_POST["cognome"])){
                                echo "value = ".$_POST["cognome"];} ?> >
                    </div>
                    <p class = "errorp"></p>
                </div>
                <div>
                    <span> Username: </span>
                    <div>
                        <div class = "form_element">
                            <img src = "images/logos/username.png">
                            <input type = "text" name = "username" id = "input_username" <?php 
                                if(isset($_POST["username"])){
                                    echo "value = ".$_POST["username"];} ?> >
                        </div>
                        <p class = "errorp"></p>
                    </div>
                </div>
                <div>
                    <span> E-mail: </span>
                    <div>
                        <div class = "form_element">
                            <img src = "images/logos/mail.png">
                            <input type = "text" name = "mail" id = "input_mail" <?php 
                                if(isset($_POST["mail"])){
                                    echo "value = ".$_POST["mail"];} ?> >
                        </div>
                        <p class = "errorp"></p>
                    </div>
                </div>
                <div>
                    <span> Password: </span>
                    <div>
                        <div class = "form_element">
                            <img src = "images/logos/password.png">
                            <input type = "password" name = "password" id = "input_pw">                   
                        </div>
                        <p class = "errorp"></p>
                    </div>
                </div>
                <div>
                    <span> Conferma password: </span>
                    <div>
                    <div class = "form_element">
                            <img src = "images/logos/password.png">
                            <input type = "password" name = "password2" id = "input_pw2">
                        </div>
                        <p class = "errorp"></p>
                    </div>
                </div>
                <div id = "tcu">
                    <input type = "checkbox" name = "tcu" value = "1"></checkbox>
                    <p> Accetto i termini e le condizioni d'uso del sito.</p>
                </div>
                <!------------------------------------------------
                    Se si è verificato errore, stampo i messaggi
                ------------------------------------------------->
                <?php if(isset($errore)) {
                    foreach($errore as $err) {
                        echo "<div class = 'errorphp'>
                        <img src='images/logos/error.png'/>
                            <p>".$err."<p>
                        </div>";
                    }
                } ?>
                <div id = "conferma">
                    <input type = "submit" value = "Registrati" id = "submit">
                </div>
                <p> Hai già un account? 
                    <a href = "login.php"> Accedi </a>
                </p>
            </form>
        </section>
    </body>
</html>