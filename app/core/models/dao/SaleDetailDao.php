<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;
use app\core\models\dto\SaleDetailDto;

final class SaleDetailDao extends BaseDao implements InterfaceDao{

    public function __construct(protected \PDO $conn) {
        parent::__construct($conn, "ventas_detalle");
    }


    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} (venta_id, item_id, nombre_item, cantidad, precio_unitario) 
                VALUES (:venta_id, :item_id, :nombre_item, :cantidad, :precio_unitario)";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function getDetailsBySaleId(int $ventaId): array {
        $sql = "SELECT dv.id, dv.venta_id, dv.item_id, dv.cantidad, dv.precio_unitario,
                       i.nombre AS nombre_item, (dv.cantidad * dv.precio_unitario) AS subtotal
                FROM {$this->table} dv
                INNER JOIN items i ON dv.item_id = i.id
                WHERE dv.venta_id = :venta_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':venta_id' => $ventaId]);

        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        
        $listaDetalles = [];
        foreach ($resultados as $row) {
            $listaDetalles[] = new SaleDetailDto($row);
        }

        return $listaDetalles;
    }

    public function load(int $id): array { return []; }
    public function update(array $data): void {  }
    public function delete(int $id): void { }
    public function list(array $filters = []): array { return []; }
}