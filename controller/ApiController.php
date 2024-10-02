<?php
namespace Controller;

use Model\Proyectos;
use Model\Tareas;
use Model\Usuarios;
use MVC\Router;

abstract class ApiController {
    public static function confirmar() {
        $token = intval($_POST["token"]);
        $resultado = Usuarios::where("token", $token);

        if($resultado["registro"]!==null) {
            $usuario = $resultado["registro"];
            $usuario->confirmarUsuario();
            $respuesta = ["resultado" => $usuario::actualizar(), "usuario" => $usuario];
        } else {
            $respuesta = ["resultado" => false, "usuario" => null];
        }

        jsonDebug($respuesta);
    }

    public static function olvido() {
        $email = $_POST["email"];
        $token = $_POST["token"];
        $respuesta = Usuarios::where("email", $email);
        $usuario = $respuesta["registro"];

        if($usuario->token !== $token) {
            $respuesta["resultado"] = false;
        }

        jsonDebug($respuesta);
    }

    public static function reestablecer() {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $respuesta = Usuarios::where("email", $email);
        $usuario = $respuesta["registro"];

        if(password_verify($password, $usuario->password)) {
            $respuesta["resultado"] = null;
        } else {
            $usuario->password = password_hash($password, PASSWORD_DEFAULT);
            $usuario->token = "";
            $usuario->setAtributos();
            $respuesta["resultado"] = $usuario::actualizar();
        }

        jsonDebug($respuesta);
    }

    public static function registrarProyecto() {
        $datos = $_POST;
        $respuestaUser = Usuarios::where("email", $datos["email"]);
        $usuario = $respuestaUser["registro"];
        $datos["usuario_id"] = $usuario->id;

        $proyecto = new Proyectos($datos);
        $alertas = $proyecto->validar();

        if(empty($alertas["error"])) {
            $proyecto->setAtributos();
            $registro = $proyecto::registrar();
        }

        jsonDebug($registro);
    }

    public static function tareas() {
        $datos = $_POST;
        $respuestaUser = Usuarios::where("email", $datos["email"]);
        $usuario = $respuestaUser["registro"];
        $idUsuario = $usuario->id;

        $respuestaProyecto = Proyectos::where("url", $datos["url"]);
        $proyecto = $respuestaProyecto["registro"];
        $idProyectoUser = $proyecto->usuario_id;
        $idProyecto = $proyecto->id;

        if($idUsuario !== $idProyectoUser) {
            header("Location: /");
        } else {
            $sql = "SELECT tareas.id as id, tarea, estado, proyecto, url FROM tareas INNER JOIN proyectos ON tareas.proyecto_id = proyectos.id WHERE url='".$datos["url"]."'";
            $tareas = Tareas::sqlCustom($sql);
        }

        jsonDebug($tareas);
    }
    
    public static function newTarea() {
        $tarea = $_POST["tarea"];
        $url = $_POST["url"];
        $proyecto = Proyectos::where("url", $url)["registro"];
        $datos = ["tarea" => $tarea, "estado" => 0, "proyecto_id" => $proyecto->id];

        $tarea = new Tareas($datos);
        if(empty($tarea->validar()["error"])) {
            $tarea->setAtributos();
            $respuesta = $tarea::registrar();
        }

        jsonDebug($respuesta);
    }

    public static function editarTarea() {
        $id = $_POST["id"];
        $nombreTarea = $_POST["tarea"];
        $estado = $_POST["estado"];

        $respuestaTarea = Tareas::where("id", $id);
        if($respuestaTarea["resultado"]) {
            $tarea = $respuestaTarea["registro"];
            $tarea->estado = ($tarea->estado === 0) ? 1 : 0;
            $tarea->setAtributos();
            $respuesta = $tarea::actualizar();
        } else {
            $respuesta = false;
        }

        jsonDebug($respuesta);
    }

    public static function eliminarTarea() {
        $id = $_POST["id"];
        $nombreTarea = $_POST["tarea"];
        $estado = $_POST["estado"];

        $respuestaTarea = Tareas::where("id", $id);
        if($respuestaTarea["resultado"]) {
            $respuesta = $respuestaTarea["registro"]::delete($id);
        } else {
            $respuesta = false;
        }

        jsonDebug($respuesta);
    }

    public static function eliminarProyecto() {
        $url = $_POST["url"];

        $respuestaTarea = Proyectos::where("url", $url);
        if($respuestaTarea["resultado"]) {
            $proyecto = $respuestaTarea["registro"];
            $respuesta = $proyecto::delete($proyecto->id);
        } else {
            $respuesta = false;
        }

        jsonDebug($respuesta);
    }
}