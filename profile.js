let page = 1;
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

/*Creo la funzione likedGames: restituirà tutti i giochi che l'utente ha aggiunto tra i preferiti
  Questa viene chiamata in tre occasioni:
    - All'apertura della pagina;
    - Quando cambio pagina di visualizzazione
    - Se l'utente interviene rimuovendo un gioco dalla lista preferiti; */
function likedGames() {
    //Preparo la fetch aggiungendo al link la pagina corrente
    const search_url = "get_favorite_games.php?page=" + page;
    fetch(search_url).then(onResponse, onError).then(onLikedGamesJson);
}

//Creo la funzione che gestisce il json tornato da getFavoriteGames.php
function onLikedGamesJson(json) {
    console.log(json);
    //Svuoto il container per eliminare l'icona di attesa
    container.innerHTML = "";
    pageContainer.innerHTML = "";
    const n = json.length;
    if (!json.length) {
        //Se non ho ancora inserito nessun gioco tra i preferiti, lo segnalo
        const box = document.createElement("div");
        box.classList.add("noGames");
        const p = document.createElement("p");
        if (page === 1) {
            p.textContent = "Non hai ancora inserito nessun gioco"
        } else {
            p.textContent = "Nessun gioco trovato"
        }       
        const image = document.createElement("img");
        image.src = "images/no_favorites.png";
        box.appendChild(image);
        box.appendChild(p);
        container.appendChild(box);
    }
    let moreGames = true;
    if (n < 9) {
        moreGames = false;
    }
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
        //Aggiungo il pulsante per rimuovere dai preferiti
        //In questo caso posso solamente rimuovere un gioco dai preferiti, per cui
        //non serve fetch: gestisco tutto qui dentro
        const div = document.createElement("div");
        div.classList.add("likeButtons");
        div.classList.add("like");
        const img2 = document.createElement("img");
        img2.src = "images/logos/like.png";
        div.appendChild(img2);
        div.addEventListener("click", unlike);
        box.appendChild(div);
    }
    //Dopo che ho aggiunto i giochi, aggiungo i pulsanti per cambiare pagina
    if (page === 1 && !moreGames) {
        return;
    }
    const b1 = document.createElement("div");
    b1.setAttribute("id", "backPage");
    const img1 = document.createElement("img");
    img1.src = "images/logos/page_back.png";
    b1.appendChild(img1);
    pageContainer.appendChild(b1);
    const b2 = document.createElement("div");
    b2.setAttribute("id", "nextPage");    
    const img2 = document.createElement("img");
    img2.src = "images/logos/page_next.png";
    b2.appendChild(img2);
    pageContainer.appendChild(b2);
    if (page === 1) {
        img1.src = "images/logos/no_page.png";
    } else {
        backPage.addEventListener("click", pageBack);
    }
    if (!moreGames) {
        img2.src = "images/logos/no_page.png";
    } else {
        nextPage.addEventListener("click", pageNext);
    }
}

//Creo la funzione che si occupa di rimuovere un gioco dai preferiti, qual'ora l'utente volesse
function unlike(event) {
    const bottone = event.currentTarget;
    //Seleziono il gioco (per passarne poi i dati)
    const gioco = bottone.parentElement;
    let titolo = gioco.querySelector(".titles");
    titolo = titolo.querySelector("p");
    const img = bottone.querySelector("img");
    //Non serve cambiare immagine nè classi: verrà rimosso dal container
    //Preparo la fetch per likeGame.php: si occuperà di RIMUOVERE il gioco dal database
    let id = gioco.querySelector(".id");
    let search_url = "like_game.php?game_id=" + id.textContent;
    search_url += "&azione=unlike";
    fetch(search_url).then(onResponse, onError).then(onLikeJson);
}

//Creo la funzione che gestisce la risposta da likeGame.php
function onLikeJson(json) {
    if (json.esito == 'ok') {
        console.log("ID: " + json.gioco + " | Azione " + json.azione + " riuscita");
        //Chiamo nuovamente likedGames per aggiornare il contenuto del container
        likedGames();
    } 
}

//Creo le funzioni che gestiscono il cambiamento di pagina
function pageBack () {
    nextPage.classList.remove("notUsable");
    //Se posso andare indietro, lo faccio
    page--;
    likedGames();
}

function pageNext () {
    backPage.classList.remove("notUsable");
    page++;
    likedGames();
}

likedGames();
