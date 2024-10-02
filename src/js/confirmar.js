let token = "";

(function() {

document.addEventListener("DOMContentLoaded", function() {
    confirmarInputs();
})

function confirmarInputs() {
    const inputs = document.querySelectorAll(".token");
    const botonConfirmar = document.querySelector(".botones");

    botonConfirmar.addEventListener("click", (e)=>{
        e.preventDefault();
    })

    inputs.forEach((tokens)=>{
        tokens.addEventListener("input", (e) => {

            if(e.target.value.length > 1) {
                tokens.value = e.target.value.slice(0, 1);

            } else if(e.target.value.length === 1) {
                tokens.nextElementSibling.focus();
                token += e.target.value;
                if(tokens.nextElementSibling == botonConfirmar) {
                    enviarConfirmacion();
                }

            } else if(e.target.value.length === 0) {
                if(tokens.previousElementSibling) {
                    tokens.previousElementSibling.focus();
                }
                token = "";
            }
        });
    })
}

async function enviarConfirmacion() {
    const url = `${window.location}/api`;
    const datos = new FormData();
    datos.append("token", token);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado.resultado) {
        Swal.fire({
            icon: "success",
            title: "Confirmada",
            text: "Su cuenta ha sido confirmada"
        }).then((result) => {
            window.location.href = window.location.origin;
        })
    } else {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al confirmar su cuenta"
        }).then((result) => {
            window.location.reload();
        })
    }
}

})();