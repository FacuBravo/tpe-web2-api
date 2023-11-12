<?php

require_once "./app/models/libros.model.php";
require_once "./app/controllers/api.controller.php";
require_once "./app/helpers/auth.api.helper.php";

class LibrosApiController extends ApiController {
    private $model, $authHelper;

    public function __construct() {
        parent::__construct();
        $this->model = new LibrosModel();
        $this->authHelper = new AuthHelper();
    }

    public function getLibros() {

        $orden = $this->_validarOrden();

        if ($orden != null) {
            $sort = $orden[0];
            
            if (!empty($orden[1])) {
                $order = $orden[1];

                $libros = $this->model->getLibros($sort, $order);
                return $this->view->response($libros, 200);
            }

            $libros = $this->model->getLibros($sort);

            return $this->view->response($libros, 200);
        }

        $libros = $this->model->getLibros();
        $this->view->response($libros, 200);
    }

    public function getLibrosFiltrados() {
        if (!empty($_GET["filterBy"])) {
            if (!empty($_GET["value"])) {
                $filter = $_GET["filterBy"];
                $value = "%" . $_GET["value"] . "%";

                if ($filter != "genero" && $filter != "titulo" && $filter != "id_autor" && $filter != "descripcion" && $filter != "precio") {
                    return $this->view->response("Filtro no válido", 400);
                }

                $orden = $this->_validarOrden();

                if ($orden != null) {
                    $sort = $orden[0];
                    
                    if (!empty($orden[1])) {
                        $order = $orden[1];
        
                        $libros = $this->model->getLibrosFiltrados($filter, $value, $sort, $order);

                        if ($libros) {
                            return $this->view->response($libros, 200);
                        }

                        return $this->view->response("No se encontraron resultados", 404);
                    }
        
                    $libros = $this->model->getLibrosFiltrados($filter, $value, $sort);

                    if ($libros) {
                        return $this->view->response($libros, 200);
                    }

                    return $this->view->response("No se encontraron resultados", 404);
                }

                $libros = $this->model->getLibrosFiltrados($filter, $value);

                if ($libros) {
                    return $this->view->response($libros, 200);
                }

                return $this->view->response("No se encontraron resultados", 404);
            }
            
            return $this->view->response("Falta el valor que desea buscar en el parámetro value", 400);
        }

        return $this->view->response("Faltan los parámetros filterBy y / o value", 400);
    }

    private function _validarOrden() {
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

                return [$sort, $order];
            }

            return [$sort];
        }

        return null;
    }

    public function getLibro($params = []) {
        $libro = $this->model->getLibro($params[":ID"]);

        if ($libro) {
            if (!empty($params[":subrecurso"])) {
                $subrecurso = $params[":subrecurso"];

                switch ($subrecurso) {
                    case 'titulo':
                        return $this->view->response("Titulo: " . $libro->titulo, 200);
                        break;
                    case 'genero':
                        return $this->view->response("Genero: " . $libro->genero, 200);
                        break;
                    case 'descripcion':
                        return $this->view->response("Descripcion: " . $libro->descripcion, 200);
                        break;
                    case 'precio':
                        return $this->view->response("Precio: " . $libro->precio, 200);
                        break;
                    case 'id':
                        return $this->view->response("Id: " . $libro->id, 200);
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
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }
        
        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }

        $id = $params[":ID"];
        $libro = $this->model->getLibro($id);

        if ($libro) {
            $this->model->eliminarLibro($id);
            return $this->view->response("El libro con el id " . $id . " fue eliminado", 200);
        }

        $this->view->response("El libro con el id " . $id . " no existe", 404);
    }

    public function newLibro() {
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }
        
        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }

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
        $user = $this->authHelper->currentUser();

        if (!$user) {
            return $this->view->response("Unauthorized", 403);
        }
        
        if (!$user->rol == "administrador") {
            return $this->view->response("Unauthorized", 403);
        }
        
        $id = $params[":ID"];
        $libro = $this->model->getLibro($id);

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