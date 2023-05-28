//In Javascript l'unico controllo che effettuo è il blocco del submit se 
//non sono stati inseriti username e password

function checkValues(event) {
    //Blocco il submit del form
    event.preventDefault();
    const username = document.querySelector("#input_username");
    const password = document.querySelector("#input_password");
    username.parentElement.parentElement.parentElement.classList.remove('jserror'); 
    password.parentElement.parentElement.parentElement.classList.remove('jserror');
    console.log(username.value, password.value);
    if((!username.value) && (!password.value)) {
        username.parentElement.parentElement.parentElement.classList.add('jserror');
        password.parentElement.parentElement.parentElement.classList.add('jserror');
        return;
    } else {
        //Se sono stati inseriti entrambi i valori, procedo
        console.log(event.target);
        event.target.submit();
    }
}

document.querySelector("form").addEventListener('submit', checkValues);