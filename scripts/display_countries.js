// DOM elements
const country_count = document.querySelector("#country-count");
const countries = document.querySelector("section#countries tbody");
const selectOrdre = document.getElementById("order");
const selectContinent = document.getElementById("continent");
const countryCountDisplay = document.querySelector("section#info > h1 > span");

/**
 * Affiche les pays et gère les fetch des pays.
 */
display_data = async () =>{
    // Doublons
    let duplicates = getParam("doublon");
    let dupl = "";
    if(duplicates != null && parseInt(duplicates) == 1){
        dupl = "&doublon=1";
    }
    let order = "&order=" + selectOrdre.value;
    let continent = "&continent=" + selectContinent.value;
    // Fetch
    await fetch("./includes/display_countries.php", {
        method: "POST",
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: "coutrycount=" + country_count.value + dupl + order + continent
    })
    .then(response =>  response.json())
    .then((response)=>{
        if(response.status == true){
            // Met à jour le nombre de pays affichés
            country_count.value = response.country_count;
            countryCountDisplay.textContent = "(" + response.country_count + ")";
            // Ajoute les nouveau pays à afficher au tableau
            countries.innerHTML += response.data;
            // Cache le bouton si tous les pays sont affichés
            if(response.maxed){
                document.querySelector("section#countries button").style.display = "none";
            }
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

// Quand l'ordre est changé
selectOrdre.addEventListener('change',()=>{
    // remet à 0 la liste
    country_count.value = 0;
    countries.innerHTML = "";
    document.querySelector("section#countries button").style.display = "initial";
    display_data();
});
// Quand le continent est changé
selectContinent.addEventListener('change',()=>{
    // remet à 0 la liste
    country_count.value = 0;
    countries.innerHTML = "";
    document.querySelector("section#countries button").style.display = "initial";
    display_data();
});
