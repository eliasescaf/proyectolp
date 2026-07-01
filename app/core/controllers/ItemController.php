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
            'app/assets/libs/jspdf.plugin.autotable.min.js',
            'app/js/item/edit.js'
        ];
        array_push($this->modules, "app/js/item/edit.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new ItemDto($data);

            $service = new ItemService();
            $service->update($dto);
            $response->setMessage("Se actualizó el item con éxito.");
            $response->send();
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
            $service = new ItemService();
            $service->delete($id);
            $response->setMessage("Se eliminó el item con éxito.");
            $response->send();
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->send(false);
        }
    }

    public function list(Request $request, Response $response){
        try {
            $filters = [
                'page'   => $request->getParameterValue('page', 1),
                'limit'  => $request->getParameterValue('limit', 10),
                'buscar' => $request->getParameterValue('buscar', ''),
                'categoria' => $request->getParameterValue('categoria', '')
            ];

            $service = new ItemService();
            $itemsDto = $service->list($filters);

            $recordsArray = [];
            foreach($itemsDto['records'] as $dto){
                $recordsArray[] = $dto->toArray();
            }
            $response->setData([
                'records' => $recordsArray,
                'meta'    => $itemsDto['meta']
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
            $service = new ItemService();
            $itemDto = $service->load($id);
            if(!$itemDto){
                throw new \Exception("No se encontró el item solicitado");
            }
            $response->setData($itemDto->toArray());
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function suggestive(Request $request, Response $response) {
        try {
            $service = new ItemService();
            
            $filters = $request->getDataFromInput() ?? []; 
            if (empty($filters) && isset($_GET['valueToSearch'])) {
                $filters = ['valueToSearch' => $_GET['valueToSearch']];
            }

            $resultadoServicio = $service->suggestive($filters);
            
            $response->setData($resultadoServicio);
            
            $response->send(true); 
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

}