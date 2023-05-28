//Con Javascript eseguo il controllo in tempo reale di alcuni campi del form

function checkNome () {
    //Se l'utente cambia campo prima di aver digitato un nome, evidenzio il campo
    const input = document.querySelector("#input_nome");
    if (input.value.length <= 0) {
        input.parentElement.parentElement.classList.add("jserror");
    } else {
        console.log(input.value);
        input.parentElement.parentElement.classList.remove("jserror");
    }
}

function checkCognome () {
    //Se l'utente cambia campo prima di aver digitato un cognome, evidenzio il campo
    const input = document.querySelector("#input_cognome");
    if (input.value.length <= 0) {
        input.parentElement.parentElement.classList.add("jserror");
    } else {
        console.log(input.value);
        input.parentElement.parentElement.classList.remove("jserror");
    }
}

//Funzione onUserJson che gestisce il Json tornato da cehckUser.php 
function onUserJson (json) {
    const input = document.querySelector("#input_username");
    if (json.exists === 1) {
        //L'username è già presente nel database
        input.parentElement.parentElement.querySelector('p').textContent = "Username già in uso.";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror');
    }
}

//Funzione onUserJson che gestisce il json restituito da checkMail.php 
function onMailJson (json) {
    const input = document.querySelector("#input_mail");
    if (json.exists === 1) {
        //La mail è già presente nel database
        input.parentElement.parentElement.querySelector('p').textContent = "Indirizzo e-mail già in uso.";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror');
    }
}

//Funzione onResponse che gestisce il valore ritornato dalle fetch
function onResponse (response) {
    if (!response.ok) {
        return null;
    } else {
        return response.json();
    }
}

function checkUsername() {
    const input = document.querySelector("#input_username");
    //Se l'utente inserisce un username non valido, lo segnalo
    if(!/^[a-zA-Z0-9_]{1,20}$/.test(input.value)) {
        input.parentElement.parentElement.querySelector('p').textContent = "Username di max 20 caratteri. Ammessi lettere, numeri o underscore.";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror'); 
        //Controllo che l'username non sia già presente nel database
        fetch("check_user.php?q=" + encodeURIComponent(input.value)).then(onResponse).then(onUserJson);
    }
}

function checkMail() {
    const input = document.querySelector("#input_mail");
    //Se l'utente inserisce una mail non valida, lo segnalo
    if(!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(input.value)) {
        input.parentElement.parentElement.querySelector('p').textContent = "E-mail non valida";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror'); 
        //Controllo che la mail non sia già presente nel database
        fetch("check_mail.php?q=" + encodeURIComponent(input.value)).then(onResponse).then(onMailJson);
    }
}

function checkPassword() {
    const input = document.querySelector("#input_pw");
    //Se l'utente inserisce una password non valida, lo segnalo
    if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(input.value)) {
        input.parentElement.parentElement.querySelector('p').textContent = "La password deve essere lunga almeno 8 caratteri, contenere almeno una lettera maiuscola, una minuscola ed un numero";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror'); 
    }
}

function checkPassword2() {
    const input = document.querySelector("#input_pw2");
    //Se l'utente inserisce una password diversa, lo segnalo
    const pw = document.querySelector("#input_pw");
    if (input.value.localeCompare(pw.value) !== 0) {
        input.parentElement.parentElement.querySelector('p').textContent = "Le due password non combaciano!";
        input.parentElement.parentElement.parentElement.classList.add('jserror'); 
    } else {
        input.parentElement.parentElement.querySelector('p').textContent = "";
        input.parentElement.parentElement.parentElement.classList.remove('jserror'); 
    }
}

document.querySelector("#input_nome").addEventListener('blur', checkNome);
document.querySelector("#input_cognome").addEventListener('blur', checkCognome);
document.querySelector("#input_username").addEventListener('blur', checkUsername);
document.querySelector("#input_mail").addEventListener('blur', checkMail);
document.querySelector("#input_pw").addEventListener('blur', checkPassword);
document.querySelector("#input_pw2").addEventListener('blur', checkPassword2);