<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\ItemDto;
use app\core\services\ItemService;
use app\libs\http\Request;
use app\libs\http\Response;

class ItemController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Productos" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        array_push($this->modules, "app/js/item/index.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Productos" => "item",
            "Nuevo producto" => null
        ];
        array_push($this->modules, "app/js/item/create.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        $data = $request->getDataFromInput();
        $dto = new ItemDto($data);
        $service = new ItemService();
        $service->save($dto);
        $response->setMessage("Se registró el item con éxito.");
        $response->send();
    }

    public function edit(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Productos" => "item",
            "Editar producto" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        array_push($this->modules, "app/js/item/edit.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){

    }

    public function delete(Request $request, Response $response){

    }

    public function list(Request $request, Response $response){
        
    }
    
    public function suggestive(Request $request, Response $response){

    }

}