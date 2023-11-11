<?php
require_once "./libs/router.php";
require_once "./app/controllers/libros.api.controller.php";
require_once "./app/controllers/autores.api.controller.php";

$router = new Router();


$router->addRoute('libros', 'GET', 'LibrosApiController', 'getLibros');
$router->addRoute('libros/filtro', 'GET', 'LibrosApiController', 'getLibrosFiltrados');
$router->addRoute('libros/:ID/', 'GET', 'LibrosApiController', 'getLibro');
$router->addRoute('libros/:ID/:subrecurso', 'GET', 'LibrosApiController', 'getLibro');
$router->addRoute('libros/:ID', 'DELETE', 'LibrosApiController', 'deleteLibro');
$router->addRoute('libros', 'POST', 'LibrosApiController', 'newLibro');
$router->addRoute('libros/:ID', 'PUT', 'LibrosApiController', 'updateLibro');


$router->addRoute('autores', 'GET', 'AutoresApiController', 'getAutores');
$router->addRoute('autores/:ID/', 'GET', 'AutoresApiController', 'getAutor');
$router->addRoute('autores/:ID/:subrecurso', 'GET', 'AutoresApiController', 'getAutor');
$router->addRoute('autores/:ID', 'DELETE', 'AutoresApiController', 'deleteAutor');
$router->addRoute('autores', 'POST', 'AutoresApiController', 'newAutor');
$router->addRoute('autores/:ID', 'PUT', 'AutoresApiController', 'updateAutor');



$router->route($_GET["resource"], $_SERVER["REQUEST_METHOD"]);