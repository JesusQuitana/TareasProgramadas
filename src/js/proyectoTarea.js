(function() {
let Alltareas = []

document.addEventListener("DOMContentLoaded", function() {
    initApp();
})

function initApp() {
    consultarTareas();
    newTarea();
    eliminarProyecto();
}

function eliminarProyecto() {
    const btn = document.querySelector("#eliminarProyecto");

    btn.addEventListener("click", async (e) => {
        const url = `${window.location.origin}/proyecto/api/eliminar`;
        const datos = new FormData();
        datos.append("url", document.querySelector("#url").value);

        const respuesta = await fetch(url, {
            method : "POST",
            body : datos
        })
        const resultado = await respuesta.json();

        if(resultado) {
            window.location.href = `${window.location.origin}/dashboard`;
        } else {
            alerta("error", "Hubo un error al eliminar la tarea")
        }
    })
}

async function consultarTareas() {
    url = `${window.location.origin}/proyecto/api/tareas`;
    datos = new FormData();
    datos.append("url", document.querySelector("#url").value);
    datos.append("email", document.querySelector("#email").value);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado.resultado) {
        Alltareas = resultado.registro;
        mostrarTareas();

    } else if(resultado.resultado == false && resultado.registro !== null) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error al consultar Tareas"
        }).then((result) => {
            window.location.reload();
        })
    } else {
        Swal.fire({
            icon: "info",
            title: "Tarea",
            text: "Agregue una nueva tarea para empezar"
        })
    }
}

function mostrarTareas() {
    const contenedorTareas = document.querySelector("#tareas");
    const tareas = document.querySelectorAll(".tarea");
    tareas.forEach((tarea)=>{
        tarea.remove();
    })

    Alltareas.forEach((tarea) => {
        const contenedorTarea = document.createElement("DIV");
        contenedorTarea.classList.add("tarea")

        const nombreTarea = document.createElement("P");
        nombreTarea.textContent = tarea.tarea;

        const acciones = document.createElement("DIV");
        acciones.classList.add("acciones")

        const estadoTarea = document.createElement("P");
        estadoTarea.classList.add("estado");
        if(tarea.estado == 0) {
            estadoTarea.classList.add("pendiente");
            estadoTarea.textContent = "Pendiente";
        } else if(tarea.estado == 1) {
            estadoTarea.classList.add("completa");
            estadoTarea.textContent = "Completada";
        }
        estadoTarea.addEventListener("click", (e)=>{
            actualizarTarea(tarea);
        })

        const eliminarTarea = document.createElement("P");
        eliminarTarea.textContent = "Eliminar";
        eliminarTarea.classList.add("eliminar");
        eliminarTarea.addEventListener("click", (e)=>{
            eliminar(tarea)
        })

        contenedorTarea.appendChild(nombreTarea)
        acciones.appendChild(estadoTarea)
        acciones.appendChild(eliminarTarea)
        contenedorTarea.appendChild(acciones)
        contenedorTareas.appendChild(contenedorTarea);
    })
}

function newTarea() {
    const btn = document.querySelector("#newTarea");
    btn.addEventListener("click", (e) => {
        modal();
    })
}

async function eliminar(tareas) {
    const url = `${window.location.origin}/proyecto/api/eliminar/tarea`
    const {id, tarea, estado} = tareas

    const datos = new FormData();
    datos.append("id", id);
    datos.append("tarea", tarea);
    datos.append("estado", estado);
    
    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado) {
        Alltareas = Alltareas.filter( tarea => tarea.id !== id )
        mostrarTareas();
    } else {
        alerta("error", "Hubo un error al eliminar la tarea")
    }
    
}

async function actualizarTarea(tareas) {
    const url = `${window.location.origin}/proyecto/api/editar/tarea`
    const {id, tarea, estado} = tareas

    const datos = new FormData();
    datos.append("id", id);
    datos.append("tarea", tarea);
    datos.append("estado", estado);
    
    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado) {
        Alltareas.map((tarea)=>{
            if(tarea.id === id) {
                tarea.estado = (tarea.estado === 0) ? 1 : 0;
            }
        })
        mostrarTareas();
    } else {
        alerta("error", "Hubo un error al eliminar la tarea")
    }
}

async function registrarTarea(nombre) {
    const url = `${window.location.origin}/proyecto/api/new/tarea`;
    const datos = new FormData();
    datos.append("tarea", nombre);
    datos.append("url", document.querySelector("#url").value);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado.resultado) {
        document.querySelector(".ventana").remove();
        Alltareas = [...Alltareas, {"id" : resultado.registro, "tarea" : nombre, "estado" : 0}];
        mostrarTareas();

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: "success",
            title: "Tarea Agregada Correctamente"
          });
          setTimeout(()=>{
            window.location.reload();
          }, 3000);
    } else {
        alerta("error", "Hubo un error al registrar la tarea")
    }
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
    titulo.textContent = "Nueva Tarea";

    const alertas = document.createElement("DIV");
    alertas.classList.add("alertas");

    const form = document.createElement("FORM");
    form.classList.add("formulario");

    const nombre = document.createElement("INPUT");
    nombre.setAttribute("type", "text");
    nombre.setAttribute("placeholder", "Nombre de la Tarea");
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
            registrarTarea(nombre.value);
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

})()