<?php

//Conectar a la Base de Datos
function conectarDB() {
    try {
        $conexion = new PDO("mysql:host={$_ENV["DB_HOST"]}; dbname={$_ENV["DB_NAME"]}; charset=utf8", "{$_ENV["DB_USERNAME"]}", "{$_ENV["DB_PASSWORD"]}");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch(Exception $e) {
        return "Error: ".$e->getMessage();
    }
}

//HELPERS
function debugear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function jsonDebug($json) {
    echo json_encode($json);
    exit;
}

function alertas($alertas) {
    foreach($alertas["error"] as $alerta) {
        echo "<p class='alerta error'>".$alerta."</p>";
    }
    foreach($alertas["exito"] as $alerta) {
        echo "<p class='alerta exito'>".$alerta."</p>";
    }
}

function verificarSesion(string $location) {
    session_start();
    if(empty($_SESSION)) {
        header("Location: ".$location);
    }
}

function script(string $script) {
    echo "<script src=/build/js/".$script.".js></script>";
}

function specialChar($dato) {
    htmlspecialchars($dato);
}