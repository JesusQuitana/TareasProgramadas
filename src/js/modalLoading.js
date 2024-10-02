(function() {
    document.addEventListener("DOMContentLoaded", function() {
        loading();
    })
    
    function loading() {
        const main = document.querySelector("main");
        const form = document.querySelector(".formulario");
    
        const ventana = document.createElement("DIV");
        ventana.classList.add("ventana");
    
        const loading = document.createElement("IMG");
        loading.setAttribute("src", "/build/img/loading.gif");
        loading.setAttribute("alt", "loading");
        loading.setAttribute("width", "114");
    
        ventana.appendChild(loading);
        
        form.addEventListener("submit", (e) => {
            main.appendChild(ventana);
        })
    }
})()