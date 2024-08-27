// Barre de recherche 
const searchBar = document.getElementById("search");
searchBar.addEventListener('keydown',(event)=>{
    if(event.key === 'Enter'){
        location.replace("./crown_caps.php?search=" + searchBar.value)
    }
})