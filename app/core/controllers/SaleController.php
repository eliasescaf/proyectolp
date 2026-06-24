<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\SaleDto;
use app\core\services\SaleService;
use app\libs\http\Request;
use app\libs\http\Response;

class SaleController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }

    public function index(Request $request, Response $response) {
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Ventas" => null
        ];
        array_push($this->modules, "app/js/sale/index.js");
        $this->modals = [
            APP_DIR_TEMPLATE . 'includes/edit_sale.php' 
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response) {
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Ventas" => "sale/index",
            "Nueva Venta" => null
        ];
        array_push($this->modules, "app/js/sale/create.js");
        
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response) {
        try {
            $data = $request->getDataFromInput();
            $dto = new SaleDto($data);
            $dto->setUsuarioId((int)$_SESSION['usuarioId']);
            $service = new SaleService();
            $service->save($dto);

            $response->setMessage("Se registró la venta con éxito.");
            $response->send(true); 
        } catch (\Exception $e) {
            $response->setMessage("Error al guardar: " . $e->getMessage());
            $response->send(false);
        }
    }

    public function load(Request $request, Response $response){
        try {
            $id = $request->getId();
            $service = new SaleService();
            $saleDto = $service->load($id);
            if(!$saleDto){
                throw new \Exception("No se encontró la venta solicitada");
            }
            $response->setData($saleDto->toArray());
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response) {}

    public function update(Request $request, Response $response) {}
    public function delete(Request $request, Response $response) {}
    public function list(Request $request, Response $response) {
        try{
            $filters = [
                'page'   => $request->getParameterValue('page', 1),
                'limit'  => $request->getParameterValue('limit', 10)
            ];

            $service = new SaleService();
            $ventasDto = $service->list($filters);
            $recordsArray = [];
            foreach($ventasDto['records'] as $dto){
                $recordsArray[] = $dto->toArray();
            }
            $response->setData([
                'records' => $recordsArray,
                'meta'    => $ventasDto['meta']
            ]);
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }
    public function suggestive(Request $request, Response $response) {}
}