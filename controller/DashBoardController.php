<?php
namespace Controller;

use Model\Proyectos;
use Model\Usuarios;
use MVC\Router;

abstract class DashBoardController {
    public static function dashboard() {
        verificarSesion("/");
        $id = $_SESSION["id"];

        $sql = "SELECT proyectos.id, proyecto, url, nombre FROM proyectos INNER JOIN usuarios ON proyectos.usuario_id=usuarios.id WHERE usuarios.id=".$id;
        $respuesta = Proyectos::sqlCustom($sql);
        
        if($respuesta["resultado"]) {
            $proyectos = $respuesta["registro"];
        }

        Router::views("dashboard/proyectos", [
            "usuario" => $_SESSION,
            "proyectos" => $proyectos
        ]);
    }

    public static function proyecto() {
        verificarSesion("/");
        $proyecto = $_GET["proyecto"];

        Router::views("dashboard/proyecto", [
            "usuario" => $_SESSION,
            "proyecto" => $proyecto
        ]);
    }

    public static function perfil() {
        verificarSesion("/");
        $usuario = Usuarios::where("id", $_SESSION["id"])["registro"];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuarioUpdate = new Usuarios($_POST);
            $usuarioUpdate->id = $usuario->id;
            $alertas = $usuarioUpdate->validar();

            if(empty($alertas["error"])) {
                $usuarioUpdate->setAtributos();
                $respuesta = $usuarioUpdate::actualizar();
                if($respuesta == false) {
                    Usuarios::setAlertas("error", "Hubo un error al actualizar tu información");
                } else {
                    Usuarios::setAlertas("exito", "Informacion Guardada con exito");
                }
            }
        }

        $alertas = Usuarios::getAlertas();
        Router::views("dashboard/perfil", [
            "session" => $_SESSION,
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function acerca() {
        verificarSesion("/");

        Router::views("dashboard/acerca", [
            "usuario" => $_SESSION
        ]);
    }
}