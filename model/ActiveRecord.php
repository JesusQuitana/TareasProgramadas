<?php
namespace Model;

use Exception;
use PDO;

abstract class ActiveRecord {
    protected static $tabla = "";
    protected static $conexionDB;
    protected static $atributos = [];
    protected static $columnasDB = [];
    protected static $alertas = ["exito", "error"];

    public static function conectarDB() {
        self::$conexionDB = conectarDB();
    }

    public static function setAlertas($tipo, $mensaje) {
        self::$alertas[$tipo][] = $mensaje;
    }

    public static function getAlertas() {
        return self::$alertas;
    }

    public static function object($registro) {
        $object = new static;
        foreach($registro as $key=>$value) {
            if(property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    public static function registrar() : array {
        $query = "INSERT INTO ".static::$tabla." (";
        $query .= join(", ", array_keys(static::$atributos)).") VALUES (:";
        $query .= join(", :", array_keys(static::$atributos)).")";

        try {
            $consulta = self::$conexionDB->prepare($query);

            foreach(static::$atributos as $key=>$value) {
                $consulta->bindValue(":".$key, $value);
            }
            $consulta->execute();

            if($consulta->rowCount()!=0) {
                return ["resultado" => true, "id" => self::$conexionDB->lastInsertId()];
            } else {
                return ["resultado" => false, "mensaje" => "Hubo un error de registro"];
            }
        }
        catch(Exception $e) {
            return ["resultado" => false, "mensaje" => "Error: ".$e->getMessage()];
        }
    }

    public static function select() {
        $query = "SELECT * FROM ".static::$tabla;
        
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();
            if($consulta->rowCount()!=0) {
                $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($registros as $registro) {
                    $objetos[] = self::object($registro);
                }
                return ["resultado" => true, "registro" => $objetos];
            } else {
                return ["resultado" => false, "registro" => null];
            }
        }
        catch(Exception $e) {
            return ["resultado" => false, "mensaje" => "Error: ".$e->getMessage()];
        }
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM ".static::$tabla." WHERE ".$columna."=:".$columna;
        
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->bindValue(":".$columna, $valor);
            $consulta->execute();
            if($consulta->rowCount()!=0) {
                $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach($registros as $registro) {
                    $objetos[] = self::object($registro);
                }
                return ["resultado" => true, "registro" => array_shift($objetos)];
            } else {
                return ["resultado" => false, "registro" => null];
            }
        }
        catch(Exception $e) {
            return ["resultado" => false, "mensaje" => "Error: ".$e->getMessage()];
        }
    }

    public static function sqlCustom(string $sql) {
        try {
            $consulta = self::$conexionDB->prepare($sql);
            $consulta->execute();
            $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);
            if($consulta->rowCount()!=0) {
                foreach($registros as $registro) {
                    $objetos[] = self::object($registro);
                }
                return ["resultado" => true, "registro" => $objetos];
            } else {
                return ["resultado" => false, "registro" => null];
            }
        }
        catch(Exception $e) {
            return ["resultado" => false, "registro" => "Error".$e->getMessage()];
        }
    }

    public static function actualizar() {
        foreach(static::$atributos as $key=>$value) {
            $array[] = $key."=:".$key;
        }
        $query = "UPDATE ".static::$tabla." SET ";
        $query .= join(", ", array_values($array));
        $query .= " WHERE id=:id";
        
        try {
            $consulta = self::$conexionDB->prepare($query);
            foreach(static::$atributos as $key=>$value) {
                $consulta->bindValue(":".$key, $value);
            }
            $consulta->execute();

            if($consulta->rowCount()!=0) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return false;
        }
    }

    public static function delete($id) {
        $query = "DELETE FROM ".static::$tabla." WHERE id=".$id;
        
        try {
            $consulta = self::$conexionDB->prepare($query);
            $consulta->execute();

            if($consulta->rowCount()!=0) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return false;
        }
    }
}