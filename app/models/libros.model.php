<?php

require_once "config.php";

class LibrosModel {
    private $bd;

    public function __construct() {
        $this->bd = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME . ';charset=' . BD_CHARSET . '', '' . BD_USER . '', '' . BD_PASS . '');
    }

    public function getLibros($sort = "id", $order = "asc") {
        $query = $this->bd->prepare("SELECT * FROM libros ORDER BY " . $sort . " " . $order);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLibro($id) {
        $query = $this->bd->prepare("SELECT * FROM libros WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getLibrosPorAutor($id) {
        $query = $this->bd->prepare("SELECT * FROM libros WHERE id_autor = ?");
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function agregarLibro($titulo, $genero, $descripcion, $precio, $autor) {
        $query = $this->bd->prepare("INSERT INTO libros (titulo, genero, id_autor, descripcion, precio) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$titulo, $genero, $autor, $descripcion, $precio]);
        return $this->bd->lastInsertId();
    }

    public function modificarLibro($id, $titulo, $genero, $autor, $descripcion, $precio) {
        $query = $this->bd->prepare("UPDATE libros SET titulo = ?, genero = ?, id_autor = ?, descripcion = ?, precio = ? WHERE id = ?");
        $query->execute([$titulo, $genero, $autor, $descripcion, $precio, $id]);
    }

    public function eliminarLibro($id) {
        $query = $this->bd->prepare("DELETE FROM libros WHERE id = ?");
        $query->execute([$id]);
    }
}