<?php

namespace app\core\services;

use app\core\models\dao\SaleDao;
use app\core\models\dao\SaleDetailDao; 
use app\core\models\dto\SaleDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection;

final class SaleService extends BaseService {
    private \PDO $conn;
    private SaleDetailDao $detailDao;

    public function __construct() {
        $this->conn = Connection::get();
        $this->detailDao = new SaleDetailDao($this->conn);
        parent::__construct(new SaleDao($this->conn));
    }

    public function save(SaleDto $dto): void {
        if(!($this->dao instanceof SaleDao)){
            throw new \Exception("El DAO no es una instancia de SaleDao");
        }

        $this->validate($dto);
        $concreteDao = $this->dao;
        $this->conn->beginTransaction();

        try{
            $concreteDao->save($dto->toArrayForSave());
            $saleId = $concreteDao->getLastInsertedId();
            $stmtCheckStock = $this->conn->prepare("SELECT stock, nombre FROM items WHERE id = :id FOR UPDATE");
            $stmtUpdateStock = $this->conn->prepare("UPDATE items SET stock = stock - :cantidad WHERE id = :id");
            
            foreach($dto->getDetalles() as $detail){
                $detail->setVentaId($saleId);

                $stmtCheckStock->execute([':id' => $detail->getItemId()]);
                $productoReal = $stmtCheckStock->fetch(\PDO::FETCH_ASSOC);
                if (!$productoReal) {
                    throw new \Exception("Uno de los productos (ID enviado: " . $detail->getItemId() . ") no existe en el catálogo");
                }

                if ($productoReal['stock'] < $detail->getCantidad()) {
                    throw new \Exception("Stock insuficiente para el producto <strong>{$productoReal['nombre']}</strong>. Disponibles: {$productoReal['stock']}");
                }

                $stmtUpdateStock->execute([
                    ':cantidad' => $detail->getCantidad(),
                    ':id' => $detail->getItemId(),
                ]);

                $this->detailDao->save($detail->toArrayForSave());
            }
            $this->conn->commit();

        }
        catch(\Exception $e){
            $this->conn->rollBack();
            throw $e;
        }
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

        $detallesArray = $this->detailDao->getDetailsBySaleId($id);
        $saleData['detalles'] = $detallesArray;
        return new SaleDto($saleData);
    }

    public function list(array $filters = []): array {
        $listaAnidada = $this->dao->list($filters);
        $listaDTOs = [];
        forEach($listaAnidada['records'] as $venta){
            $listaDTOs[] = new SaleDto($venta);
        }
        return [
            'records' => $listaDTOs,
            'meta'    => $listaAnidada['meta']
        ];
    }

    private function validate(SaleDto $dto): void {
        if ($dto->getUsuarioId() <= 0) {
            throw new \Exception("La venta debe estar asociada a un <strong>vendedor</strong> con sesión activa.");
        }
        if (count($dto->getDetalles()) === 0) {
            throw new \Exception("No se puede registrar una transacción sin <strong>productos</strong> en el carrito.");
        }
        if ($dto->getTotal() <= 0) {
            throw new \Exception("El monto <strong>total</strong> facturado de la venta debe ser mayor a cero.");
        }
    }
}