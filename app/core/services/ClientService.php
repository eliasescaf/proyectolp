<?php

namespace app\core\services;

use app\core\models\dao\ClientDao;
use app\core\models\dto\ClientDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection; 

final class ClientService extends BaseService{

    function __construct() {
        parent::__construct(new ClientDao(Connection::get()));
    }

    public function save(ClientDto $dto){
        $this->validate($dto);
        $this->dao->save($dto->toArrayForSave());
    }   

    public function update(ClientDto $dto){
        $this->validate($dto);
        $this->dao->update($dto->toArray());
    }

    public function delete(int $id){
        $this->dao->delete($id);
    }

    public function load(int $id): ?ClientDto{
        $clientData = $this->dao->load($id);

        if(!$clientData){
            return null;
        }

        return new ClientDto($clientData);
    }

    public function list(array $filters = []){
        $listaAnidada = $this->dao->list($filters);
        $listaDTOs = [];
        forEach($listaAnidada['records'] as $cliente){
            $listaDTOs[] = new ClientDto($cliente);
        }
        return [
            'records' => $listaDTOs,
            'meta'    => $listaAnidada['meta']
        ];
    }

    public function suggestive(array $filters): array {
        if (!isset($filters["valueToSearch"]) || trim($filters["valueToSearch"]) === "") {
            throw new \Exception("Se requiere el filtro <strong>valueToSearch</strong> para realizar búsquedas <strong>sugestivas</strong>.");
        }
        
        /** @var ClientDao $concreteDao */
        $concreteDao = $this->dao;
        
        $records = $concreteDao->suggestive($filters);
        $stmt = Connection::get()->query("SELECT FOUND_ROWS()");
        $foundedRecords = (int)$stmt->fetchColumn();
        
        return [
            "records" => $records,
            "foundedRecords" => $foundedRecords
        ];
    }

    private function validate(ClientDto $dto): void{
        if (strlen(trim($dto->getNombre())) === 0) {
            throw new \Exception("El campo <strong>Nombre</strong> es obligatorio.");
        }

        $cuit = trim($dto->getCuit());
        if (strlen($cuit) > 0 && strlen($cuit) !== 11) {
            throw new \Exception("El <strong>CUIT</strong> debe contener exactamente 11 dígitos numéricos.");
        }
    }
}