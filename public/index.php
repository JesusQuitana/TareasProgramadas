<?php
require_once dirname(__DIR__) . '/includes/app.php';
use MVC\Router;
use Controller\ApiController;
use Controller\LogController;
use Controller\DashBoardController;

//####################METODOS ASOCIADOS A LAS APIS
Router::validarRutasPost("/confirmar/api", [ApiController::class, "confirmar"]);
Router::validarRutasPost("/reestablecer/api/validar", [ApiController::class, "olvido"]);
Router::validarRutasPost("/reestablecer/api/reestablecer", [ApiController::class, "reestablecer"]);

Router::validarRutasPost("/dashboard/api/proyecto/new", [ApiController::class, "registrarProyecto"]);

Router::validarRutasPost("/proyecto/api/tareas", [ApiController::class, "tareas"]);
Router::validarRutasPost("/proyecto/api/new/tarea", [ApiController::class, "newTarea"]);
Router::validarRutasPost("/proyecto/api/editar/tarea", [ApiController::class, "editarTarea"]);
Router::validarRutasPost("/proyecto/api/eliminar", [ApiController::class, "eliminarProyecto"]);
Router::validarRutasPost("/proyecto/api/eliminar/tarea", [ApiController::class, "eliminarTarea"]);

//####################METODOS ASOCIADOS A LAS CUENTAS DE LOS USUARIOS
//Login de los Usuarios
Router::validarRutasGet("/", [LogController::class, "index"]);
Router::validarRutasPost("/", [LogController::class, "index"]);
Router::validarRutasGet("/logout", [LogController::class, "logout"]);

//Registro de Usuarios
Router::validarRutasGet("/registro", [LogController::class, "registro"]);
Router::validarRutasPost("/registro", [LogController::class, "registro"]);

//Confirmar cuenta de Usuarios
Router::validarRutasGet("/confirmar", [LogController::class, "confirmar"]);
Router::validarRutasPost("/confirmar", [LogController::class, "confirmar"]);

//Olvido contraseña de Usuarios
Router::validarRutasGet("/olvido", [LogController::class, "olvido"]);
Router::validarRutasPost("/olvido", [LogController::class, "olvido"]);

//Reestablecer Contraseña
Router::validarRutasPost("/reestablecer", [LogController::class, "reestablecer"]);

//####################METODOS ASOCIADOS AL DASHBOARD
Router::validarRutasGet("/dashboard", [DashBoardController::class, "dashboard"]);
Router::validarRutasGet("/proyecto", [DashBoardController::class, "proyecto"]);
Router::validarRutasGet("/perfil", [DashBoardController::class, "perfil"]);
Router::validarRutasPost("/perfil", [DashBoardController::class, "perfil"]);
Router::validarRutasGet("/acerca", [DashBoardController::class, "acerca"]);


Router::comprobarURL();