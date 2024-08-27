// DOM elements
const page_count = document.querySelector("#page-count");
const crown_caps = document.querySelector("section#crown-caps > div:nth-child(2)");
const button_plus = document.querySelector("section#crown-caps > div:first-child > button:nth-child(3)");
const button_minus = document.querySelector("section#crown-caps > div:first-child > button");
const crown_count = document.querySelector("section#crown-caps > div:first-child > span");

/**
 * Affiche les capsules et gère les fetch des capsules.
 */
display_data = async (page_increment,country=null,search=null)=>{
    // Pays 
    let coun = "";
    if(country != null && country != ""){
        coun = "&country=" + country;
    }
    // Recherche
    let sear = "";
    if(search != null && search != ""){
        sear = "&search=" + search
    }
    // Doublons
    let duplicates = getParam("doublon");
    let dupl = "";
    if(duplicates != null && parseInt(duplicates) == 1){
        dupl = "&doublon=1";
    }
    // Numéro de page
    page_count.value = parseInt(page_count.value) + page_increment;
    // Fetch
    await fetch("./includes/display_crown_caps.php", {
        method: "POST",
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: "pagecount=" + page_count.value + coun + sear + dupl
    })
    .then(response =>  response.json())
    .then((response)=>{
        if(response.status == true){
            // Insère le nouveau HTML
            crown_caps.innerHTML = response.data;
            // Met à jour le compteur de capsules
            crown_count.textContent = response.start + "-" + response.end + " /"+ crown_count.textContent.split("/")[1];
            // Met à jour les boutons de navigation des pages
            button_plus.disabled = false;
            button_minus.disabled = false;
            if(response.maxed){
                button_plus.disabled = true;
            }
            if(response.mined){
                button_minus.disabled = true;
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
window.addEventListener('load',()=>{
    // Récupère les paramètre
    let country = getParam("country");
    let search = getParam("search");
    // Si on est sur la page de recherche
    if(search != null){
        let searchBar = document.querySelector("main > input#search");
        searchBar.addEventListener('keydown',(event)=>{
            if(event.key === 'Enter'){
                location.replace("./crown_caps.php?search=" + searchBar.value)
            }
        });
    }
    // affiche les données
    display_data(0,country,search);
});

// Quand le numéro de page est changé
page_count.addEventListener('change',()=>display_data(0,getParam("country"),getParam("search")));