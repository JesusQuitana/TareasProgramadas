<?php
namespace Controller;

use Model\Email;
use Model\Usuarios;
use MVC\Router;

abstract class LogController {
    public static function confirmar() {

        Router::views("account/confirmar", [
            
        ]);
    }

    public static function logout() {
        session_start();
        if($_SESSION["login"] == true) {
            $_SESSION = [];
            header("Location: /");
        }
    }

    public static function index() {
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $respuesta = Usuarios::where("email", $email);

            if($respuesta["resultado"]) {
                $usuario = $respuesta["registro"];
                if(password_verify($password, $usuario->password)) {
                    session_start();
                    $_SESSION["login"] = true;
                    $_SESSION["nombre"] = $usuario->nombre;
                    $_SESSION["email"] = $usuario->email;
                    $_SESSION["id"] = $usuario->id;
                    header("Location: /dashboard"); 
                    
                } else {
                    Usuarios::setAlertas("error", "Contraseña Incorrecta");
                }
            } else {
                Usuarios::setAlertas("error", "Usuario Invalido");
            }
        }

        $alertas = Usuarios::getAlertas();
        Router::views("account/log", [
            "alertas" => $alertas
        ]);
    }

    public static function registro() {
        //Crear Nuevo Usuario
        if($_SERVER["REQUEST_METHOD"]==="POST") {
            $datos = $_POST;
            $usuario = new Usuarios($datos);
            $alertas = $usuario->validar();

            if(empty($alertas["error"])) {
                $usuario->setAtributos();
                $registro = $usuario::registrar();

                if($registro["resultado"]) {
                    $email = Email::enviarConfirmacion($usuario->token, $usuario->email, $usuario->nombre);
                    $email = true ? header("Location: /confirmar") : $usuario::setAlertas("error", "Error al Enviar Confirmacion"); 
                } else {
                    $usuario::setAlertas("error", "Error al Registrar Usuario");
                }
            }
            $alertas = $usuario::getAlertas();
        }

        Router::views("account/registro", [
            "alertas" => $alertas
        ]);
    }

    public static function olvido() {
        $resp = filter_var($_GET["resp"], FILTER_VALIDATE_INT);
        if($resp === 0) {
            Usuarios::setAlertas("error", "Usuario No Encontrado");
        }

        $alertas = Usuarios::getAlertas();
        Router::views("account/olvido", [
            "alertas" => $alertas
        ]);
    }

    public static function reestablecer() {
        $token = rand(100000, 999999);
        $email = $_POST["email"];
        $consulta = Usuarios::where("email", $email);

        if($consulta["resultado"] == false) {
            header("Location: /olvido?resp=0");
        } else {
            Email::enviarReestablecer($token, $email);      
            $usuario = $consulta["registro"];
            $usuario->token = $token;
            $usuario->setAtributos();
            if($usuario::actualizar()) {
                Usuarios::setAlertas("exito", "Hemos enviado a su correo un token valido, ingreselo a continuación");
            } else {
                header("Location: /olvido");
            }
        }
        
        $alertas = Usuarios::getAlertas();
        Router::views("account/reestablecer", [
            "alertas" => $alertas,
            "email" => $email
        ]);
    }
}