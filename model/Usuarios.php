<?php
namespace Model;

class Usuarios extends ActiveRecord {
    protected static $tabla = "usuarios";
    protected static $atributos = [];
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password_repeat;

    public function __construct(array $datos = [])
    {
        $this->id = $datos["id"] ?? 0;
        $this->nombre = $datos["nombre"] ?? "";
        $this->email = $datos["email"] ?? "";
        $this->password = $datos["password"] ?? "";
        $this->password_repeat = $datos["password_repeat"] ?? "";
        $this->token = $datos["token"] ?? "";
        $this->confirmado = $datos["confirmado"] ?? 0;
    }

    public function setAtributos() {
        foreach(static::$columnasDB as $columna) {
            static::$atributos[$columna] = $this->$columna;
        }
    }

    public function validar() : array {
        if(!$this->nombre) {
            self::setAlertas("error", "Debe Ingresar un Nombre Valido");
        }
        if(!$this->email) {
            self::setAlertas("error", "Debe Ingresar un E-Mail Valido");
        }
        if(!$this->password || strlen($this->password)<6) {
            self::setAlertas("error", "Debe Ingresar una Contraseña Valida (Min: 6 Caracteres)");
        }
        if($this->password !== $this->password_repeat) {
            self::setAlertas("error", "Las Contraseñas deben ser coincidir");
        }
        
        if(empty(self::$alertas["error"])) {
            $this->token = rand(100000, 999999);
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        return self::getAlertas();
    }

    public function confirmarUsuario() {
        $this->token = "";
        $this->confirmado = 1;
        $this->setAtributos();
    }
}