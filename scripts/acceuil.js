// Barre de recherche de <main>
const mainSearchBar = document.querySelector("main input#search");
// clear search input
const eraseButton = document.querySelector("main input#search + button");

mainSearchBar.addEventListener('keydown',(event)=>{
    if(event.key === 'Enter'){
        window.location.href = "./crown_caps.php?search=" + mainSearchBar.value;
    }
});
// Check search bar emptyness to display erase button
mainSearchBar.addEventListener('input',(event)=>{
    if(mainSearchBar.value.trim().length > 0){
        eraseButton.style.visibility = "initial";
    }else{
        eraseButton.style.visibility = "hidden";
    }
});

// Erase search bar content
eraseButton.addEventListener('click',()=>{
    mainSearchBar.value = "";
    mainSearchBar.focus();
    eraseButton.style.visibility = "hidden";
});

// Barre de recherche principale
const searchBarSubmit = document.querySelector("main input#search + button + button");

searchBarSubmit.addEventListener('click',()=>{
    window.location.href = "./crown_caps.php?search=" + mainSearchBar.value;
});