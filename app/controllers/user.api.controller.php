<?php

require_once "./app/models/usuarios.model.php";
require_once "./app/controllers/api.controller.php";
require_once "./app/helpers/auth.api.helper.php";

class UserApiController extends ApiController {
    private $model, $authHelper;

    public function __construct() {
        parent::__construct();
        $this->model = new UsuariosModel();
        $this->authHelper = new AuthHelper();
    }

    public function getToken() {
        $basic = $this->authHelper->getAuthHeaders();

        if (empty($basic)) {
            return $this->view->response("No envió encabezados de autenticación", 400);
        }

        $basic = explode(" ", $basic);

        if ($basic[0] != "Basic") {
            return $this->view->response("Los encabezados de autenticación son incorrectos", 400);
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass);

        $user = $userpass[0];
        $pass = $userpass[1];

        $userdata = $this->model->getPorUsuario($user);

        if ($userdata && password_verify($pass, $userdata->contrasenia)) {
            $userdata = (object) ['id' => $userdata->id, 'usuario' => $userdata->usuario, 'rol' => $userdata->rol,];
            $token = $this->authHelper->createToken($userdata);
            $this->view->response($token, 200);
        } else {
            $this->view->response("El usuario o contraseñas son incorrectos", 400);
        }
    }
}