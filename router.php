<?php
require_once "./libs/router.php";
require_once "./app/controllers/libros.api.controller.php";

$router = new Router();


$router->addRoute('libros', 'GET', 'LibrosApiController', 'getLibros');
$router->addRoute('libros/:ID/', 'GET', 'LibrosApiController', 'getLibro');
$router->addRoute('libros/:ID/:subrecurso', 'GET', 'LibrosApiController', 'getLibro');
$router->addRoute('libros/:ID', 'DELETE', 'LibrosApiController', 'deleteLibro');
$router->addRoute('libros', 'POST', 'LibrosApiController', 'newLibro');
$router->addRoute('libros/:ID', 'PUT', 'LibrosApiController', 'updateLibro');



$router->route($_GET["resource"], $_SERVER["REQUEST_METHOD"]);