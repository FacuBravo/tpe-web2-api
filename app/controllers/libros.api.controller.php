<?php

require_once "./app/models/libros.model.php";
require_once "./app/controllers/api.controller.php";

class LibrosApiController extends ApiController {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new LibrosModel();
    }

    public function getLibros() {
        if (!empty($_GET["sort"])) {
            $sort = $_GET["sort"];

            if ($sort != "titulo" && $sort != "genero" && $sort != "descripcion" && $sort != "precio" && $sort != "id" && $sort != "id_autor") {
                return $this->view->response("Los libros no se puede ordenar por " . $sort . " porque no lo contienen", 400);
            }

            if (!empty($_GET["order"])) {
                $order = $_GET["order"];

                if ($order != "desc" && $order != "asc") {
                    return $this->view->response("Los libros no se pueden ordenar de forma " . $order, 400);
                }

                $libros = $this->model->getLibros($sort, $order);
                return $this->view->response($libros, 200);
            }

            $libros = $this->model->getLibros($sort);
            return $this->view->response($libros, 200);
        } 

        $libros = $this->model->getLibros();
        $this->view->response($libros, 200);
    }

    public function getLibro($params = []) {
        $libro = $this->model->getLibroPorId($params[":ID"]);

        if ($libro) {
            if (!empty($params[":subrecurso"])) {
                $subrecurso = $params[":subrecurso"];

                switch ($subrecurso) {
                    case 'titulo':
                        return $this->view->response($libro->titulo, 200);
                        break;
                    case 'genero':
                        return $this->view->response($libro->genero, 200);
                        break;
                    case 'descripcion':
                        return $this->view->response($libro->descripcion, 200);
                        break;
                    case 'precio':
                        return $this->view->response($libro->precio, 200);
                        break;
                    default:
                        return $this->view->response("El libro no tiene " . $subrecurso, 400);
                        break;
                }
            }

            return $this->view->response($libro, 200);
        }

        $this->view->response("El libro con el id " . $params[":ID"] . " no existe", 404);
    }

    public function deleteLibro($params = []) {
        $id = $params[":ID"];
        $libro = $this->model->getLibroPorId($id);

        if ($libro) {
            $this->model->eliminarLibro($id);
            return $this->view->response("El libro con el id " . $id . " fue eliminado", 200);
        }

        $this->view->response("El libro con el id " . $id . " no existe", 404);
    }

    public function newLibro() {
        $body = $this->getData();

        if (!empty($body->titulo) && !empty($body->genero) && !empty($body->descripcion) && !empty($body->precio) && !empty($body->id_autor)) {
            $titulo = $body->titulo;
            $genero = $body->genero;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $autor = $body->id_autor;

            $id = $this->model->agregarLibro($titulo, $genero, $descripcion, $precio, $autor);

            if ($id) {
                return $this->view->response("Libro agregado con el id " . $id, 201);
            }
    
            return $this->view->response("Error al insertar el libro", 500);
        }

        $this->view->response("Falta información", 400);
    }

    public function updateLibro($params = []) {
        $id = $params[":ID"];
        $libro = $this->model->getLibroPorId($id);

        if ($libro) {
            $body = $this->getData();

            if (!empty($body->titulo) && !empty($body->genero) && !empty($body->descripcion) && !empty($body->precio) && !empty($body->id_autor)) {
                $titulo = $body->titulo;
                $genero = $body->genero;
                $descripcion = $body->descripcion;
                $precio = $body->precio;
                $autor = $body->id_autor;

                $this->model->modificarLibro($id, $titulo, $genero, $autor, $descripcion, $precio);
                return $this->view->response("El libro con el id " . $id . " se actualizó correctamente", 200);
            }

            return $this->view->response("Falta información", 400);
        }

        $this->view->response("El libro con el id " . $id . " no existe", 404);
    }
}