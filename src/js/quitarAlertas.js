document.addEventListener("DOMContentLoaded", function() {
    const alerta = document.querySelector(".alerta");

    setTimeout(()=>{
        alerta.remove();
    }, 2000)
})