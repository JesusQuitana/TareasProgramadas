<?php
namespace Model;

class Tareas extends ActiveRecord {
    protected static $tabla = "tareas";
    protected static $atributos = [];
    protected static $columnasDB = ["id", "tarea", "estado", "proyecto_id"];

    public $id;
    public $tarea;
    public $estado;
    public $proyecto_id;

    public function __construct(array $datos = [])
    {
        $this->id = $datos["id"] ?? 0;
        $this->tarea = $datos["tarea"] ?? "";
        $this->estado = $datos["estado"] ?? 0;
        $this->proyecto_id = $datos["proyecto_id"] ?? 0;
    }

    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }

    public function validar() {
        if(!$this->tarea) {
            self::setAlertas("error", "Indique un nombre a la tarea");
        }
        if(!$this->proyecto_id) {
            self::setAlertas("error", "Proyecto Invalido");
        }

        if(empty(self::getAlertas()["error"])) {
            $this->estado = 0;
        }
        return self::getAlertas();
    }
}