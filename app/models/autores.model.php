<?php

require_once "config.php";

class AutoresModel {
    private $bd;

    public function __construct() {
        $this->bd = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME . ';charset=' . BD_CHARSET . '', '' . BD_USER . '', '' . BD_PASS . '');
    }

    public function getAutor($id) {
        $query = $this->bd->prepare("SELECT * FROM autores WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getAutores($sort = "id", $order = "asc") {
        $query = $this->bd->prepare("SELECT * FROM autores ORDER BY " . $sort . " " . $order);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function agregarAutor($nombreAutor, $descripcionAutor) {
        $query = $this->bd->prepare("INSERT INTO autores (nombre, descripcion) VALUES (?, ?)");
        $query->execute([$nombreAutor, $descripcionAutor]);
        return $this->bd->lastInsertId();
    }

    public function eliminarAutor($id) {
        $query = $this->bd->prepare("DELETE FROM autores WHERE id = ?");
        $query->execute([$id]);
    }

    public function modificarAutor($id, $nombreAutor, $descripcionAutor) {
        $query = $this->bd->prepare("UPDATE autores SET nombre = ?, descripcion = ? WHERE id = ?");
        $query->execute([$nombreAutor, $descripcionAutor, $id]);
    }
}