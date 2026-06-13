<?php

namespace app\core\services;

use app\core\models\dao\SaleDao;
use app\core\models\dto\SaleDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection; 

final class SaleService extends BaseService {

    public function __construct() {
        parent::__construct(new SaleDao(Connection::get()));
    }

    public function save(SaleDto $dto): void {
        $this->validate($dto);
        $this->dao->save($dto->toArrayForSave());
    }   

    public function update(SaleDto $dto): void {
        $this->dao->update($dto->toArray());
    }

    public function delete(int $id): void {
        $this->dao->delete($id);
    }

    public function load(int $id): ?SaleDto {
        $saleData = $this->dao->load($id);

        if (!$saleData) {
            return null;
        }

        return new SaleDto($saleData);
    }

    public function list(array $filters = []): array {
        $listaAnidada = $this->dao->list($filters);
        $listaDTOs = [];
        foreach ($listaAnidada as $sale) {
            $listaDTOs[] = new SaleDto($sale);
        }
        return $listaDTOs;
    }

    private function validate(SaleDto $dto): void {
        if ($dto->getUsuarioId() <= 0) {
            throw new \Exception("La venta debe estar asociada a un <strong>usuario</strong> válido.");
        }
        if ($dto->getTotal() <= 0) {
            throw new \Exception("El <strong>total</strong> de la venta debe ser mayor a cero.");
        }
    }
}