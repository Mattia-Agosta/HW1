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

/*Creo la funzione topGames: restituirà i 10 giochi aggiunti ai preferiti da più utenti
    - All'apertura della pagina;
    - Se l'utente interviene rimuovendo o aggiungendo un gioco dalla lista preferiti; */
function topGames() {
    //Devo solamente fare la fetch
    fetch("get_top_games.php").then(onResponse, onError).then(onTopGamesJson);
}

//Creo la funzione che gestisce il json tornato da getTopGames.php
function onTopGamesJson(json) {
    console.log(json);
    //Svuoto il container per eliminare l'icona di attesa
    container.innerHTML = "";
    let n = 10;
    if (!json.length) {
        //Se non ho ancora inserito nessun gioco tra i preferiti, lo segnalo
        const box = document.createElement("div");
        box.classList.add("noGames");
        const p = document.createElement("p");
        p.textContent = "Nessun gioco presente"
        const image = document.createElement("img");
        image.src = "images/no_favorites.png";
        box.appendChild(image);
        box.appendChild(p);
        container.appendChild(box);
        return;
    } else if (json.length < 10){
        //Se sono presenti meno di 10 giochi
        n = json.length;
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
        const a4 = document.createElement("div");
        const b4 = document.createElement("span");
        const c4 = document.createElement("p");
        b4.textContent = "N. Likes: ";
        a4.appendChild(b4);
        c4.textContent = game.n_likes;
        a4.appendChild(c4);
        a4.classList.add("genres");
        data.appendChild(a4);        
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
        const a5 = document.createElement("div");
        a5.classList.add("id");
        a5.textContent = game.game_id;
        data.appendChild(a5);
        //Aggiungo l'immagine corrispondente al piazzamento in classifica 
        const img3 = document.createElement("img");
        img3.src = "images/ranking_" + (i + 1) + ".png"; 
        img3.classList.add("ranking");
        box.appendChild(img3);
        //Aggiungo il pulsante per aggiungere o rimuovere dai preferiti
        //Devo però sapere se il gioco fa già parte dei preferiti: faccio una fetch e lascio
        //che ad occuparsi di tutto sia onControlJson
        const search_url = "fetch_game.php?game_id=" + game.game_id+ "&game_number=" + i;
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
    //Dopo aver compiuto l'azione, devo aggiornare la classifica!
    topGames();
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

topGames();
