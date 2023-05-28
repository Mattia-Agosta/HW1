
//Creo le funzioni che gestistono le ricerche per tutti
function onResponse(response) {
    if (!response.ok) {
        console.log ("Ricevuta risposta non valida");
        console.log(response);
        return null;
    }
    console.log ("Risposta ricevuta!");
    return response.json();
}

function onError (error) {
    console.log ("Errore: " + error);
    return null;
}

//Creo la funzione myGames: ogni volta che viene caricata la pagina, vengono estratti 5 giochi a caso
//da un mio database personale di 20. Questi andranno a costituire la sezione "giochi consigliati"
function myGames() {
    //Faccio la fetch
    const search_url = "my_games.php";
    fetch(search_url).then(onResponse, onError).then(onMyGamesJson);
}

//Creo la funzione che gestisce il json di giochi
function onMyGamesJson(json) {
    console.log(json);
    //Svuoto il container per eliminare l'icona di attesa
    container.innerHTML = "";
    const n = 5;
    //Itero tra i giochi e costruisco per ognuno il proprio box
    for (let i = 0; i < n; i++) {
        const game = json[i];
        const box = document.createElement("div");
        box.classList.add("game");
        box.setAttribute("id", "game_" + i);
        //Prendo l'immagine
        const image = document.createElement("img");
        image.classList.add("mainImage");
        if (game.img) {
            image.src = game.img;
        } else {
            //Se il gioco non ha un'immagine, uso un placeholder
            image.src = "images/placeholder.jpg"
        }       
        box.appendChild(image);
        container.appendChild(box);
        //Aggiungo i dati che mi interessano
        const data = document.createElement("div");
        data.classList.add("gameData");
        box.appendChild(data);
        const a = document.createElement("div");
        const b = document.createElement("span");
        const c = document.createElement("p");
        b.textContent = "Titolo: ";
        c.textContent = game.titolo;
        a.classList.add("titles")
        a.appendChild(b);
        a.appendChild(c);
        data.appendChild(a);
        const a3 = document.createElement("div");
        const b3 = document.createElement("span");
        const c3 = document.createElement("p");
        b3.textContent = "Genere: ";
        a3.appendChild(b3);
        c3.textContent = game.genere;
        a3.appendChild(c3);
        a3.classList.add("genres");
        data.appendChild(a3);
        const a1 = document.createElement("div");
        const b1 = document.createElement("span");
        const c1 = document.createElement("p");
        b1.textContent = "Data di rilascio: ";
        c1.textContent = game.data;
        a1.appendChild(b1);
        a1.appendChild(c1);
        a1.classList.add("dates");
        data.appendChild(a1);
        const a2 = document.createElement("div");
        const b2 = document.createElement("span");
        const c2 = document.createElement("p");
        b2.textContent = "Piattaforme: ";
        a2.appendChild(b2);
        c2.textContent = game.piattaforme;
        a2.appendChild(c2);
        a2.classList.add("platforms");
        data.appendChild(a2);
       //Salvo l'id ma non lo mostro: servirà per l'inserimento/rimozione dai preferiti
        const a4 = document.createElement("div");
        a4.classList.add("id");
        a4.textContent = game.game_id;
        data.appendChild(a4);
        //Aggiungo il pulsante per aggiungere o rimuovere dai preferiti
        //Devo però sapere se il gioco fa già parte dei preferiti: faccio una fetch e lascio
        //che ad occuparsene sia onControlJson
        const search_url = "fetch_game.php?game_id=" + game.game_id + "&game_number=" + i;
        fetch(search_url).then(onResponse, onError).then(onControlJson);
    }
}

//Scrivo la funzione che gestirà il meccanismo di aggiunta/rimozione dai preferiti
function like (event) {
    //Come prima cosa, distinguo se voglio AGGIUNGERE o RIMUOVERE il gioco dai preferiti
    const bottone = event.currentTarget;
    //Seleziono il gioco (per passarne poi i dati)
    const gioco = bottone.parentElement;
    let titolo = gioco.querySelector(".titles");
    titolo = titolo.querySelector("p");
    const img = bottone.querySelector("img");
    if (bottone.classList.contains("unlike")) {
        //Se il pulsante non è già premuto, allora voglio AGGIUNGERE il gioco
        //Ne cambio l'immagine
        img.src = "images/logos/like.png";
        //Ne modifico le classi
        bottone.classList.remove("unlike");
        bottone.classList.add("like");
        //Preparo la fetch per likeGame.php: si occuperà di AGGIUNGERE il gioco dal database
        //(Scrivo più istruzioni per migliorare la leggibilità)
        let id = gioco.querySelector(".id");
        let search_url = "like_game.php?game_id=" + encodeURIComponent(id.textContent);
        search_url += "&azione=like";
        search_url += "&titolo=" + encodeURIComponent(titolo.textContent);
        let g_img = gioco.querySelector(".mainImage");
        search_url += "&img=" + encodeURIComponent(g_img.src);
        let genere = gioco.querySelector(".genres");
        genere = genere.querySelector("p");
        search_url += "&genere=" + encodeURIComponent(genere.textContent);
        let data = gioco.querySelector(".dates");
        data = data.querySelector("p");
        search_url += "&data=" + encodeURIComponent(data.textContent);
        let piattaforme = gioco.querySelector(".platforms");
        piattaforme = piattaforme.querySelector("p");
        search_url += "&piattaforme=" + encodeURIComponent(piattaforme.textContent);
        fetch(search_url).then(onResponse, onError).then(onLikeJson);
    }
    else {
        //Se il pulsante è già premuto, allora voglio RIMUOVERE il gioco
        //Ne cambio l'immagine
        img.src = "images/logos/unlike.png";
        //Ne modifico le classi
        bottone.classList.add ("unlike");
        bottone.classList.remove ("like");
        //Preparo la fetch per likeGame.php: si occuperà di RIMUOVERE il gioco dal database
        //In questo caso, basta passare solo 'ID
        let id = gioco.querySelector(".id");
        let search_url = "like_game.php?game_id=" + id.textContent;
        search_url += "&azione=unlike";
        fetch(search_url).then(onResponse, onError).then(onLikeJson);
    }
}

//Creo la funzione che gestisce la risposta da likeGame.php
function onLikeJson(json) {
    if (json.esito == 'ok') {
        console.log("ID: " + json.gioco + " | Azione " + json.azione + " riuscita");
    }
}

//Creo la funzione che gestisce la risposta da fetchGame.php
function onControlJson(json) {
    const div = document.createElement("div");
    div.classList.add("likeButtons");
    console.log(json);
    if (json.value === "LIKE") {
        //Se viene ritornato LIKE significa che il gioco è già tra i preferiti
        div.classList.add("like");
        const img2 = document.createElement("img");
        img2.src = "images/logos/like.png";
        div.appendChild(img2);
        div.addEventListener("click", like);
        const box = document.querySelector("#game_" + json.n);
        box.appendChild(div);
    } else {
        //Il gioco non è tra i preferiti
        div.classList.add("unlike");
        const img2 = document.createElement("img");
        img2.src = "images/logos/unlike.png";
        div.appendChild(img2);
        div.addEventListener("click", like);
        const box = document.querySelector("#game_" + json.n)
        box.appendChild(div);
    }  
}

//Creo la funzione che gestisce PokeAPI: si occuperà di riempire la sezione 3 della pagina
//Si tratta di un API libera, senza chiavi o autenticazione.
function pokeApi() {
    let giorno = new Date();
    giorno =  Math.floor((giorno - new Date(giorno.getFullYear(), 0, 0)) / 1000 / 60 / 60 / 24);
    console.log(giorno);
    //Preparo la fetch
    const searchUrl = "pokeApi.php?q=" + giorno;
    fetch(searchUrl).then(onResponse, onError).then(onPokeJson)
}

//Creo la funzione che gestisce il json di PokeAPI
function onPokeJson(json) {
    console.log(json);
    //Titolo...
    const titolo = document.querySelector("#pokeTitle");
    let nome = json.name;
    nome = nome.charAt(0).toUpperCase() + nome.slice(1);
    titolo.textContent = "Il Pokèmon del giorno è " + nome;
    //...Immagine...
    const img = document.createElement("img");
    img.src = json.sprites.other["official-artwork"].front_default;
    document.querySelector("#PokeIMG").appendChild(img);
    //... E dati
    const pd = document.querySelector("#PokeData");
    const a = document.createElement("div");
    const b = document.createElement("span");
    const c = document.createElement("p");
    b.textContent = "Nome: ";
    c.textContent = nome;
    a.appendChild(b);
    a.appendChild(c);
    pd.appendChild(a);
    const a1 = document.createElement("div");
    const b1 = document.createElement("span");
    const c1 = document.createElement("p");
    b1.textContent = "Numero di Pokèdex: ";
    c1.textContent = json.id;
    a1.appendChild(b1);
    a1.appendChild(c1);
    pd.appendChild(a1);
    const a2 = document.createElement("div");
    const b2 = document.createElement("span");
    const c2 = document.createElement("p");
    b2.textContent = "Tipo: ";
    let tipo1 = '';
    let tipo2 = '';
    if (json.types.length === 1) {
        tipo1 = json.types[0].type.name;
        tipo1 = tipo1.charAt(0).toUpperCase() + tipo1.slice(1);
    } else {
        tipo1 = json.types[0].type.name;
        tipo1 = tipo1.charAt(0).toUpperCase() + tipo1.slice(1);
        tipo2 = json.types[1].type.name;
        tipo2 = tipo2.charAt(0).toUpperCase() + tipo2.slice(1);
        tipo2 = ' - ' + tipo2;
    }
    c2.textContent = tipo1 + tipo2;
    a2.appendChild(b2);
    a2.appendChild(c2);
    pd.appendChild(a2);
    const a3 = document.createElement("div");
    const b3 = document.createElement("span");
    const c3 = document.createElement("p");
    b3.textContent = "Regione di appartenenza: ";
    if (json.id < 152) {
        c3.textContent = "Kanto";
    } else if (json.id < 153) {
        c3.textContent = "Johto";
    } else {
        c3.textContent = "Hoenn";
    }
    a3.appendChild(b3);
    a3.appendChild(c3);
    pd.appendChild(a3);
}

//PokeAPI entra in funzione all'apertura della pagina
pokeApi();
//myGames entra in funzione all'apertura della pagina
myGames();