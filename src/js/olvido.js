(function() {
    let usuario = {
        email : document.querySelector("#email").value,
        token : "",
        password : "",
        password_repeat : ""
    };

document.addEventListener("DOMContentLoaded", function() {
    validarToken();
})

function alerta(tipo, mensaje) {
    const alertas = document.querySelector(".alertas")
    const alertaPrevia = document.querySelector(".alerta")

    if(alertaPrevia == null) {
        const alerta = document.createElement("P");
        alerta.classList.add("alerta");
        alerta.classList.add(tipo);
        alerta.textContent = mensaje;
        alertas.appendChild(alerta);
        setTimeout(()=>{
            alerta.remove();
        }, 2000)
    } else {
        return;
    }        
}

function reestablecerInputs() {
    const inputs = document.querySelectorAll(".token");
    usuario.token = "";
    
    inputs.forEach((input) => {
        input.value = "";
    })
}

function validarToken() {
    const inputs = document.querySelectorAll(".token");
    const botones = document.querySelector(".botones").firstElementChild;

    botones.addEventListener("click", (e)=>{
        e.preventDefault();
        verificarToken();
    })

    inputs.forEach((tokens)=>{
        tokens.addEventListener("input", (e) => {
            if(e.target.value.length > 1) {
                tokens.value = e.target.value.slice(0, 1);

            } else if(e.target.value.length === 1) {
                tokens.nextElementSibling.focus();
                usuario.token += e.target.value;

            } else if(e.target.value.length === 0) {
                if(tokens.previousElementSibling) {
                    tokens.previousElementSibling.focus();
                }
            }
        })
    })
}

async function verificarToken() {
    const url = `${window.location}/api/validar`;
    const datos = new FormData();
    datos.append("email", usuario.email);
    datos.append("token", usuario.token);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })

    const resultado = await respuesta.json();

    if(resultado.resultado) {
        modal();
    } else {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Token No Valido"
        }).then((result) => {
            reestablecerInputs();
        })
    }
}

function modal() {
    const main = document.querySelector(".registro");
        
    const ventana = document.createElement("DIV");
    ventana.classList.add("ventana");

    const modal = document.createElement("DIV");
    modal.classList.add("modal")

    const cerrar = document.createElement("DIV");
    cerrar.classList.add("iconcerrar");
    cerrar.innerHTML = `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>`

    const titulo = document.createElement("H3");
    titulo.textContent = "Reestablecer Contraseña";

    const alertas = document.createElement("DIV");
    alertas.classList.add("alertas");

    const form = document.createElement("FORM");
    form.classList.add("formulario");

    const password = document.createElement("INPUT");
    password.setAttribute("type", "password");
    password.setAttribute("placeholder", "Tu Nueva Contraseña");
    password.setAttribute("id", "password");

    const password_repeat = document.createElement("INPUT");
    password_repeat.setAttribute("type", "password");
    password_repeat.setAttribute("placeholder", "Repite Tu Contraseña");
    password_repeat.setAttribute("id", "password_repeat");

    const submit = document.createElement("INPUT");
    submit.setAttribute("type", "submit");
    submit.classList.add("btn");
    submit.classList.add("verde");

    modal.appendChild(cerrar);
    modal.appendChild(titulo);
    modal.appendChild(alertas);
    form.appendChild(password);
    form.appendChild(password_repeat);
    form.appendChild(submit);
    modal.appendChild(form);
    ventana.appendChild(modal);
    main.appendChild(ventana);

    submit.addEventListener("click", (e)=>{
        e.preventDefault();
        validarPassword(password, password_repeat);
    })

    cerrar.addEventListener("click", (e)=> {
        reestablecerInputs();
        ventana.remove();
    })

    ventana.addEventListener("click", (e)=>{
        if(e.target == ventana) {
            reestablecerInputs();
            ventana.remove();
        }
    })
}

function validarPassword(password, password_repeat) {
    if(password.value == "" || password.value.length < 6) {
        alerta("error", "Agregue una contraseña Valida");
    } else if(password.value !== password_repeat.value) {
        alerta("error", "Deben Coincidir las contraseñas");
    } else {
        usuario.password = password.value;
        usuario.password_repeat = password_repeat.value;
        reestablecer();
    }
}

async function reestablecer() {
    const url = `${window.location}/api/reestablecer`;
    const datos = new FormData();
    datos.append("password", usuario.password);
    datos.append("email", usuario.email);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    });
    const resultado = await respuesta.json();

    if(resultado.resultado) {
        reestablecerInputs();
        document.querySelector(".ventana").remove();

        let timerInterval;
        Swal.fire({
        icon : "success",
        title: "Contraseña Cambiada con Exito",
        html: "",
        timer: 3000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
            timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
        }).then(()=>{
            window.location.href = window.location.origin;
        })

        setTimeout(() => {
            window.location.href = window.location.origin;
        }, 3000)

    } else if(resultado.resultado == null) {
        alerta("error", "La Contraseña debe ser distinta a la anterior");
    } else {
        reestablecerInputs();
        document.querySelector(".ventana").remove();
    }
}

})();