// DOM elements
const sets = document.querySelector("section#sets > div");
const setsCountDisplay = document.querySelector("section#info > h1 > span");
const setsSearchBar = document.querySelector("section#options input#SetSearch");
// clear search input
const eraseButton = document.querySelector("section#options input#SetSearch + button");

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
        body: "input=" + setsSearchBar.value.trim()
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

// Après chargement de la page
window.addEventListener('load',display_data);
setsSearchBar.addEventListener('input',display_data);

// Check search bar emptyness to display erase button
setsSearchBar.addEventListener('input',(event)=>{
    if(setsSearchBar.value.trim().length > 0){
        eraseButton.style.visibility = "initial";
    }else{
        eraseButton.style.visibility = "hidden";
    }
});

// Erase search bar content
eraseButton.addEventListener('click',()=>{
    setsSearchBar.value = "";
    setsSearchBar.focus();
    eraseButton.style.visibility = "hidden";
    display_data();
});