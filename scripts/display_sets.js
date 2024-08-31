// DOM elements
const sets = document.querySelector("section#sets > div");
const setsCountDisplay = document.querySelector("section#info > h1 > span");

/**
 * Affiche les pays et gère les fetch des pays.
 */
display_data = async () =>{
    // Fetch
    await fetch("./includes/display_sets.php", {
        method: "POST",
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: ""
    })
    .then(response =>  response.json())
    .then((response)=>{
        if(response.status == true){
            // Met à jour le nombre de pays affichés
            setsCountDisplay.textContent = "(" + response.sets_count + ")";
            //  Ajoute les sets au HTML
            sets.innerHTML = response.data;
        }
    });
}

/**
 * Cherche dans l'url le paramètre demandé et retourne sa valeur ou null
 * @param {string} param  Paramètre cherché
 * @returns string ou null
 */
function getParam(param){
    var qs = window.location.search.substring(1).split('&');
    var qsp;
    for (p in qs){
        qsp = qs[p].split('=');
        if (qsp[0] == param) return qsp[1]; 
    }
    return null;
}

// Après chargement de la page
window.addEventListener('load',display_data);