<?php
namespace MVC;

abstract class Router {
    protected static $rutasGET = [];
    protected static $rutasPOST = [];

    public static function validarRutasGet(string $url, array $metodo) {
        return self::$rutasGET[$url] = $metodo;
    }

    public static function validarRutasPost(string $url, array $metodo) {
        self::$rutasPOST[$url] = $metodo;
    }

    public static function comprobarURL() {
        $urlActual = strtok($_SERVER["REQUEST_URI"], "?") ?? "/";
        
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $metodo = self::$rutasGET[$urlActual];
        } else {
            $metodo = self::$rutasPOST[$urlActual];
        }

        if($metodo === null) {
            echo "<h1>Pagina No Encontrada</h1>";
        } else {
            call_user_func($metodo);
        }
    }

    public static function views(string $view, array $datos = []) {
        ob_start();
        foreach($datos as $key=>$value) {
            $$key = $value;
        }
        include_once __DIR__ . '/views'."/".$view.".php";
        $contenido = ob_get_clean();

        include __DIR__ . '/views/layout.php';
    }
}