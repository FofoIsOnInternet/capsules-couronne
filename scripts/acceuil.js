// Barre de recherche de <header>
const mainSearchBar = document.querySelector("main input#search");

mainSearchBar.addEventListener('keydown',(event)=>{
    if(event.key === 'Enter'){
        window.location.href = "./crown_caps.php?search=" + mainSearchBar.value;
    }
});


// Barre de recherche principale
const searchBarSubmit = document.querySelector("main input#search + button");

searchBarSubmit.addEventListener('click',()=>{
    window.location.href = "./crown_caps.php?search=" + mainSearchBar.value;
});