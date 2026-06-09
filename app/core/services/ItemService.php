<?php

namespace app\core\services;

use app\core\models\dao\ItemDao;
use app\core\models\dto\ItemDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection; 

final class ItemService extends BaseService {

    function __construct() {
        parent::__construct(new ItemDao(Connection::get()));
    }

    public function save(ItemDto $dto){
        $this->validate($dto);
        $this->dao->save($dto->toArrayForSave());
    }   

    public function update(ItemDto $dto){
        $this->dao->update($dto->toArray());
    }

    public function delete(int $id){
        $this->dao->delete($id);
    }

    public function load(int $id): ?ItemDto{
        $itemData = $this->dao->load($id);

        if(!$itemData){
            return null;
        }

        return new ItemDto($itemData);
    }

    public function list(array $filters = []){
        $listaAnidada = $this->dao->list($filters);
        $listaDTOs = [];
        forEach ($listaAnidada as $item){
            $listaDTOs[] = new ItemDto($item);
        }
        return $listaDTOs;
    }

    private function validate(ItemDto $dto): void{
        if (strlen(trim($dto->getNombre())) === 0) {
            throw new \Exception("El campo <strong>nombre</strong> es obligatorio.");
        }
        
        if ($dto->getStock() < 0) {
            throw new \Exception("El <strong>stock</strong> del ítem no puede ser un número negativo.");
        }
        
        if ($dto->getPrecio() < 0) {
            throw new \Exception("El campo <strong>precio</strong> no puede ser menor a cero.");
        }

        if ($dto->getCategoria() <= 0) {
            throw new \Exception("Debe seleccionar una <strong>categoría</strong> válida.");
        }
        
        if ($dto->getRiego() <= 0) {
            throw new \Exception("Debe especificar un nivel de <strong>riego</strong> válido.");
        }
    }
}