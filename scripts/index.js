// Barre de recherche de <header>
const searchBar = document.getElementById("search");
searchBar.addEventListener('keydown',(event)=>{
    if(event.key === 'Enter'){
        window.location.href = "./crown_caps.php?search=" + searchBar.value;
    }
})