let page = 1;
/* Creo la funzione che si occuperà di fare la fetch a getGames.php e
   cercare i giochi. Entrerà in funzione in due casi: 
   - All'apertura della pagina
   - Al submit del form (passando da submitGames)*/
function searchGames() {
    const search = document.querySelector("#searchBar");
    //Controllo necessario per evitare una ricerca vuota poichè la funzione
    //viene chiamata ad ogni apertura della pagina
    if (search.value) {
        //preparo la fetch
        const search_url = "get_games.php?q=" + encodeURIComponent(search.value) + "&page=" + page;
        console.log(search_url);
        fetch(search_url).then(onResponse, onError).then(onGamesJson);
    }
}

function submitGames(event) {
    //Evito il ricaricamento della pagina
    event.preventDefault();
    const container = document.querySelector("#container");
    //Se è stato fatto il submit senza digitare un parametro, visualizzo errore
    const search = document.querySelector("#searchBar")
    if (!search.value) {
        const error = document.createElement("div");
        error.classList.add("error");
        const img = document.createElement("img");
        img.src = "images/logos/error.png";
        const p = document.createElement("p");
        p.textContent = "Inserire un parametro di ricerca";
        error.appendChild (img);
        error.appendChild (p);
        container.appendChild (error);
        return;
    } else {
        searchGames();
    }
}

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

//Creo la funzione che gestisce il Json tornato da getGames.php (a sua volta da RAWG)
function onGamesJson (json) {
    console.log(json);
    const container = document.querySelector("#container");
    //Svuoto il container
    container.innerHTML = "";
    pageContainer.innerHTML = "";
    //Itero tra gli elementi e li aggiungo alla pagina, ognuno nel suo box personale
    let items = 9;
    if (json.results.length < 9) {
        items = json.results.length;
    }
    //Se non è stato trovato nessun gioco, visualizzo un messaggio di errore
    if (!items) {
        const error = document.createElement("div");
        error.classList.add("error");
        const img = document.createElement("img");
        img.src = "images/logos/error.png";
        const p = document.createElement("p");
        p.textContent = "Nessun gioco trovato!";
        error.appendChild (img);
        error.appendChild (p);
        container.appendChild (error);
        return;
    } 
    let moreGames = true;
    if(!json.next) {
        moreGames = false;
    }
    for (let i = 0; i < items; i++) {
        const game = json.results[i];
        const box = document.createElement("div");
        box.classList.add("game");
        box.setAttribute("id", "game_" + i);
        //Prendo l'immagine
        const image = document.createElement("img");
        image.classList.add("mainImage");
        if (game.background_image) {
            image.src = game.background_image;
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
        c.textContent = game.name;
        a.classList.add("titles");
        a.appendChild(b);
        a.appendChild(c);
        data.appendChild(a);
        const a1 = document.createElement("div");
        const b1 = document.createElement("span");
        const c1 = document.createElement("p");
        b1.textContent = "Genere: ";
        a1.appendChild(b1);
        //Inserisco max 3 generi, per evitare di intasare
        let n = 3;
        if (game.genres.length < 3) {
            n = game.genres.length;
        }
        if (game.genres[0]) {
            const g1 = game.genres[0].name;
            c1.textContent = g1;
        } else {
            c1.textContent = "no data";
            c1.classList.add("noData");
        }
        for (let k = 1; k < n; k++) {
            const g = ', ' + game.genres[k].name;
            c1.textContent += g;
        }
        a1.classList.add("genres");
        a1.appendChild(c1);
        data.appendChild(a1);
        const a2 = document.createElement("div");
        const b2 = document.createElement("span");
        const c2 = document.createElement("p");
        b2.textContent = "Data di rilascio: ";
        c2.textContent = game.released;
        a2.classList.add("dates");
        a2.appendChild(b2);
        a2.appendChild(c2);
        data.appendChild(a2);
        const a3 = document.createElement("div");
        const b3 = document.createElement("span");
        const c3 = document.createElement("p");
        b3.textContent = "Piattaforme: ";
        a3.appendChild(b3);
        //Inserisco max 5 piattaforme, per evitare di intasare
        n = 5;
        if (!game.platforms.length) {
            c3.textContent = "no data";
            c3.classList.add("noData");
        } else {
            if (game.platforms.length < 5) {
            n = game.platforms.length
            }
            const p1 = game.platforms[0].platform.name;
            c3.textContent = p1;
            for (let k = 1; k < n; k++) {
                const p = ', ' + game.platforms[k].platform.name;
                c3.textContent += p;
            }
        }
        a3.classList.add("platforms");
        a3.appendChild(c3);
        data.appendChild(a3);
        //Salvo l'id ma non lo mostro: servirà per l'inserimento/rimozione dai preferiti
        const a4 = document.createElement("div");
        a4.classList.add("id");
        a4.textContent = game.id;
        data.appendChild(a4);
        //Aggiungo il pulsante per aggiungere o rimuovere dai preferiti
        //Devo però sapere se il gioco fa già parte dei preferiti: faccio una fetch e lascio
        //che ad occuparsene sia onControlJson
        const search_url = "fetch_game.php?game_id=" + game.id+ "&game_number=" + i;
        fetch(search_url).then(onResponse, onError).then(onControlJson);
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
        //Basta passare solo ID e tipo di azione
        let id = gioco.querySelector(".id");
        let search_url = "like_game.php?game_id=" + encodeURIComponent(id.textContent);
        search_url += "&azione=unlike";
        fetch(search_url).then(onResponse, onError).then(onLikeJson);
    }
}

//Creo la funzione che gestisce la risposta da likeGame.php
function onLikeJson(json) {
    if (json.esito == 'ok') {
        console.log("ID: " + json.gioco + " | Azione " + json.azione + " riuscita");
    }
    else {
        console.log("Azione non riuscita");
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

//Creo le funzioni che gestiscono il cambiamento di pagina
function pageBack () {
    nextPage.classList.remove("notUsable");
    //Se posso andare indietro, lo faccio
    page--;
    searchGames();
}

function pageNext () {
    backPage.classList.remove("notUsable");
    page++;
    searchGames();
}

searchGames();
document.querySelector("form").addEventListener("submit", submitGames);