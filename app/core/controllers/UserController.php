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

    }
}