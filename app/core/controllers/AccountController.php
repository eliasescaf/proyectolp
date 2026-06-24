<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\services\UserService;
use app\libs\http\Request;
use app\libs\http\Response;

class AccountController extends BaseController{
    public function __construct(){
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Mis datos" => null
        ];
        array_push($this->modules, "app/js/account/index.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function load(Request $request, Response $response){
        try {
            $idLogueado = (int)$_SESSION['usuarioId'];
            $userService = new UserService();
            $usuarioDto = $userService->load($idLogueado);
            if(!$usuarioDto){
                throw new \Exception("No se encontró el usuario solicitado");
            }
            $response->setData([
                'id'        => $usuarioDto->getId(),
                'nombre'    => $usuarioDto->getNombre(),
                'cuenta'    => $usuarioDto->getCuenta(),
                'perfil'    => $usuarioDto->getPerfil(),
                'correo'    => $usuarioDto->getCorreo(),
                'estado'    => $usuarioDto->getEstado(),
                'fechaAlta' => $usuarioDto->getFechaAlta(),
                'resetPass' => $usuarioDto->getResetPass()
            ]);
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function updatePassword(Request $request, Response $response){
        try{
            $data = $request->getDataFromInput();
            $idUsuario = (int)$_SESSION['usuarioId'];
            $userService = new UserService();
            $userDto = $userService->load($idUsuario);
            if(!$userDto){
                throw new \Exception("Usuario no logueado");
            }
            $userDto->setContraseña($data['contrasenia']);
            $userService->updatePassword($userDto);
            $response->setMessage("Contraseña actualizada con éxito.");
            $response->send(true);
        }catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }
}