<?php

require_once "./app/models/autores.model.php";
require_once "./app/models/libros.model.php";
require_once "./app/controllers/api.controller.php";
require_once "./app/helpers/auth.api.helper.php";

class AutoresApiController extends ApiController {
    private $model, $modelLibros, $authHelper;

    public function __construct() {
        parent::__construct();
        $this->model = new AutoresModel();
        $this->modelLibros = new LibrosModel();
        $this->authHelper = new AuthHelper();
    }

    public function getAutores() {
        if (!empty($_GET["sort"])) {
            $sort = $_GET["sort"];

            if ($sort != "nombre" && $sort != "descripcion" && $sort != "id") {
                return $this->view->response("Los autores no se puede ordenar por " . $sort . " porque no lo contienen", 400);
            }

            if (!empty($_GET["order"])) {
                $order = $_GET["order"];

                if ($order != "desc" && $order != "asc") {
                    return $this->view->response("Los autores no se pueden ordenar de forma " . $order, 400);
                }

                $autores = $this->model->getAutores($sort, $order);
                return $this->view->response($autores, 200);
            }

            $autores = $this->model->getAutores($sort);
            return $this->view->response($autores, 200);
        } 

        $autores = $this->model->getAutores();
        $this->view->response($autores, 200);
    }

    public function getAutor($params = []) {
        $autor = $this->model->getAutor($params[":ID"]);

        if ($autor) {
            if (!empty($params[":subrecurso"])) {
                $subrecurso = $params[":subrecurso"];

                switch ($subrecurso) {
                    case 'nombre':
                        return $this->view->response("Nombre: " . $autor->nombre, 200);
                        break;
                    case 'descripcion':
                        return $this->view->response("Descripcion: " . $autor->descripcion, 200);
                        break;
                    case 'id':
                        return $this->view->response("Id: " . $autor->id, 200);
                        break;
                    default:
                        return $this->view->response("El autor no tiene " . $subrecurso, 400);
                        break;
                }
            }

            return $this->view->response($autor, 200);
        }

        $this->view->response("El autor con el id " . $params[":ID"] . " no existe", 404);
    }

    public function deleteAutor($params = []) {
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }

        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }

        $id = $params[":ID"];
        $autor = $this->model->getAutor($id);

        if ($autor) {
            $librosAutor = $this->modelLibros->getLibrosPorAutor($id);

            if (!empty($librosAutor)) {
                return $this->view->response("El autor con el id " . $id . " no se pudo eliminar porque tiene libros", 400);
            } else {
                $this->model->eliminarAutor($id);
                return $this->view->response("El autor con el id " . $id . " fue eliminado", 200);
            }
        }

        $this->view->response("El autor con el id " . $id . " no existe", 404);
    }

    public function newAutor() {
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }
        
        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }

        $body = $this->getData();

        if (!empty($body->nombre) && !empty($body->descripcion)) {
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;

            $id = $this->model->agregarAutor($nombre, $descripcion);

            if ($id) {
                return $this->view->response("Autor agregado con el id " . $id, 201);
            }
    
            return $this->view->response("Error al agregar el autor", 500);
        }

        $this->view->response("Falta información", 400);
    }

    public function updateAutor($params = []) {
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }

        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }

        $id = $params[":ID"];
        $autor = $this->model->getAutor($id);

        if ($autor) {
            $body = $this->getData();

            if (!empty($body->nombre) && !empty($body->descripcion)) {
                $nombre = $body->nombre;
                $descripcion = $body->descripcion;

                $this->model->modificarAutor($id, $nombre, $descripcion);
                return $this->view->response("El autor con el id " . $id . " se actualizó correctamente", 200);
            }

            return $this->view->response("Falta información", 400);
        }

        $this->view->response("El autor con el id " . $id . " no existe", 404);
    }
}