<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\models\dto\ClientDto;
use app\core\services\ClientService;
use app\libs\http\Request;
use app\libs\http\Response;

class ClientController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Clientes" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        array_push($this->modules, "app/js/client/index.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Clientes" => "client",
            "Nuevo cliente" => null
        ];
        array_push($this->modules, "app/js/client/create.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new ClientDto($data);
            $service = new ClientService();
            
            $service->save($dto);
            $response->setMessage("Se registró el cliente con éxito.");
            $response->send(true); 
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function edit(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => "home/index",
            "Clientes" => "client",
            "Editar cliente" => null
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js',
            'app/js/client/edit.js'
        ];
        array_push($this->modules, "app/js/client/edit.js");
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){
        try {
            $data = $request->getDataFromInput();
            $dto = new ClientDto($data);

            $service = new ClientService();
            $service->update($dto);
            $response->setMessage("Se actualizó el cliente con éxito.");
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
            $service = new ClientService();
            $service->delete($id);
            $response->setMessage("Se eliminó el cliente con éxito.");
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
                'limit'  => $request->getParameterValue('limit', 10)
            ];
            
            $service = new ClientService();
            $clientsDto = $service->list();

            $recordsArray = [];
            foreach($clientsDto['records'] as $dto){
                $recordsArray[] = $dto->toArray();
            }
            $response->setData([
                'records' => $recordsArray,
                'meta'    => $clientsDto['meta']
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
            $service = new ClientService();
            $clientDto = $service->load($id);
            if(!$clientDto){
                throw new \Exception("No se encontró el cliente solicitado");
            }
            $response->setData($clientDto->toArray());
            $response->send(true);
        }
        catch(\Exception $e){
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function suggestive(Request $request, Response $response){
        try {
            $service = new ClientService();
            
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