// imports
import Cookie from "./cookie.js";

// Barre de recherche de <header>
const searchBar = document.getElementById("search");
searchBar.addEventListener('keydown',(event)=>{
    if(event.key === 'Enter'){
        window.location.href = "./crown_caps.php?search=" + searchBar.value;
    }
});

// Theme changer button
const themeButton = document.getElementById("theme-mode");

const updateTheme = ()=>{
    let image = themeButton.querySelector("img");
    let html = document.querySelector("html");
    if(html.getAttribute("theme") == "light"){
        html.setAttribute("theme","dark");
        image.setAttribute("src","./images/icones/light_mode.svg");
        Cookie.setCookie("theme","dark");
    }else{
        html.setAttribute("theme","light");
        image.setAttribute("src","./images/icones/dark_mode.svg");
        Cookie.setCookie("theme","light");
    }
}

themeButton.addEventListener('click',updateTheme);
document.addEventListener('DOMContentLoaded',()=>{
    let theme = Cookie.getCookie("theme");
    let html = document.querySelector("html");
    if(theme != html.getAttribute("theme")){
        updateTheme();
    }
});