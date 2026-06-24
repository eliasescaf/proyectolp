<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\UserDto;
use app\core\services\UserService;
use app\libs\http\Request;
use app\libs\http\Response;

class UserController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Usuarios" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        array_push($this->modules, "app/js/user/index.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Usuarios" => "user",
            "Nuevo usuario" => null
        ];
        array_push($this->modules, "app/js/user/create.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        $data = $request->getDataFromInput();
        $dto = new UserDto($data);
        $service = new UserService();
        $service->save($dto);
        $response->setMessage("Se registró el usuario con éxito.");
        $response->send();
    }

    public function edit(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Usuarios" => "user",
            "Editar usuario" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        array_push($this->modules, "app/js/user/edit.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new UserDto($data);

            $service = new UserService();
            $service->update($dto);
            $response->setMessage("Se actualizó el usuario con éxito.");
            $response->send();
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
        
    }

    public function list(Request $request, Response $response){
        try {
            $filters = [
                'page'   => $request->getParameterValue('page', 1),
                'limit'  => $request->getParameterValue('limit', 10)
            ];

            $service = new UserService();
            $usuariosDto = $service->list($filters);

            $recordsArray = [];
            foreach($usuariosDto['records'] as $dto){
                    $recordsArray[] = [
                    'id'        => $dto->getId(),
                    'nombre'    => $dto->getNombre(),
                    'cuenta'    => $dto->getCuenta(),
                    'perfil'    => $dto->getPerfil(),
                    'correo'    => $dto->getCorreo(),
                    'estado'    => $dto->getEstado(),
                    'fechaAlta' => $dto->getFechaAlta(),
                    'resetPass' => $dto->getResetPass()
                ];
            }
            $response->setData([
                'records' => $recordsArray,
                'meta'    => $usuariosDto['meta']
            ]);
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function load(Request $request, Response $response){
        try {
            $id = $request->getId();
            $service = new UserService();
            $usuarioDto = $service->load($id);
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

    public function delete(Request $request, Response $response){
        try {
            $id = $request->getId();
            $service = new UserService();
            $service->delete($id);
            $response->setMessage("Se eliminó el usuario con éxito.");
            $response->send();
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }
}