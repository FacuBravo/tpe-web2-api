<?php

require_once "config.php";

class UsuariosModel {
    private $bd;

    public function __construct() {
        $this->bd = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME . ';charset=' . BD_CHARSET . '', '' . BD_USER . '', '' . BD_PASS . '');
    }

    public function getPorUsuario($usuario) {
        $query = $this->bd->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $query->execute([$usuario]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function nuevoUsuario($usuario, $contrasenia) {
        $query = $this->bd->prepare("INSERT INTO usuarios (usuario, contrasenia, rol) VALUES (?, ?, 'usuario')");
        $query->execute([$usuario, $contrasenia]);
    }
}