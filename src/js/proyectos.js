(function() {
    document.addEventListener("DOMContentLoaded", function() {
        initApp();
    })

    function initApp() {
        newProyecto();
    }

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

    function modal() {
        const main = document.querySelector(".uptask");
            
        const ventana = document.createElement("DIV");
        ventana.classList.add("ventana");
    
        const modal = document.createElement("DIV");
        modal.classList.add("modal")

        const cerrar = document.createElement("DIV");
        cerrar.classList.add("iconcerrar");
        cerrar.innerHTML = `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>`
    
        const titulo = document.createElement("H3");
        titulo.textContent = "Nuevo Proyecto";
    
        const alertas = document.createElement("DIV");
        alertas.classList.add("alertas");
    
        const form = document.createElement("FORM");
        form.classList.add("formulario");
    
        const nombre = document.createElement("INPUT");
        nombre.setAttribute("type", "text");
        nombre.setAttribute("placeholder", "Nombre del Proyecto");
        nombre.setAttribute("id", "nombre");
        nombre.setAttribute("name", "nombre");
    
        const submit = document.createElement("INPUT");
        submit.setAttribute("type", "submit");
        submit.classList.add("btn");
        submit.classList.add("verde");
    
        modal.appendChild(cerrar);
        modal.appendChild(titulo);
        modal.appendChild(alertas);
        form.appendChild(nombre);
        form.appendChild(submit);
        modal.appendChild(form);
        ventana.appendChild(modal)
        main.appendChild(ventana);
    
        submit.addEventListener("click", (e)=>{
            e.preventDefault();
            if(nombre.value == "") {
                alerta("error", "Agregue un Nombre")
            } else {
                registrarProyecto(nombre.value);
            }
        })

        cerrar.addEventListener("click", (e)=> {
            ventana.remove();
        })
    
        ventana.addEventListener("click", (e)=>{
            if(e.target == ventana) {
                ventana.remove();
            }
        })
    }

    function newProyecto() {
        const newbtn = document.querySelector("#newProyecto");

        newbtn.addEventListener("click", (e)=> {
            modal();
        })
    }

    async function registrarProyecto(nombre, ventana) {
        const url = `${window.location}/api/proyecto/new`
        const datos = new FormData();
        datos.append("proyecto", nombre)
        datos.append("email", document.querySelector("#email").value)

        const respuesta = await fetch(url, {
            method : "POST",
            body : datos
        })
        const resultado = await respuesta.json();

        if(resultado.resultado) {
            document.querySelector(".ventana").remove();
            Swal.fire({
                icon: "success",
                title: "Tarea Guardada",
                text: "Tarea guardada con Exito"
            }).then((result) => {
                window.location.reload();
            })
        } else {
            document.querySelector(".ventana").remove();
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Hubo un error al registrar la tarea"
            }).then((result) => {
                window.location.reload();
            })
        }
    }

})();