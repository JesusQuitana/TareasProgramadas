<?php
namespace Model;

class Proyectos extends ActiveRecord {
    protected static $tabla = "proyectos";
    protected static $atributos = [];
    protected static $columnasDB = ["id", "proyecto", "url", "usuario_id"];
    
    public $id;
    public $proyecto;
    public $url;
    public $usuario_id;

    public function __construct(array $datos = [])
    {
        $this->id = $datos["id"] ?? 0;
        $this->proyecto = $datos["proyecto"] ?? "";
        $this->url = $datos["url"] ?? "";
        $this->usuario_id = $datos["usuario_id"] ?? 0;
    }

    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }

    public function validar() {
        if(!$this->proyecto) {
            self::setAlertas("error", "Debe Agregar un Nombre");
        }
        if(!$this->usuario_id) {
            self::setAlertas("error", "Usuario Invalido");
        }

        if(empty(self::$alertas["error"])) {
            $this->url = uniqid(rand(), true);
        }

        return self::getAlertas();
    }
}