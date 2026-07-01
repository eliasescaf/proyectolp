<?php
namespace app\core\models\dao;

use app\core\models\dto\SaleDto;
use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class SaleDao extends BaseDao implements InterfaceDao{
    private ?int $lastInsertedId = null;

    public function __construct(protected \PDO $conn){
        parent::__construct($conn, 'ventas');
    }

    public function save(array $data): void {
            //LOCK tables WRITE usuarios WRITE clientes WRITE ventas_numeracion WRITE ventas WRITE ventas_detalle;
            $sqlNum = "SELECT ultimo_numero FROM ventas_numeracion FOR UPDATE";
            $stmtNum = $this->conn->prepare($sqlNum);
            $stmtNum->execute();
            $ultimoNum = (int)$stmtNum->fetch(\PDO::FETCH_ASSOC)['ultimo_numero'];
            $nuevoNumeroVenta = $ultimoNum + 1;
            $sqlUpdateNum = "UPDATE ventas_numeracion SET ultimo_numero = :nuevo";
            $stmtUpdateNum = $this->conn->prepare($sqlUpdateNum);
            $stmtUpdateNum->execute([':nuevo' => $nuevoNumeroVenta]);

            $sql = "INSERT INTO {$this->table} (numero_venta, usuario_id, cliente_id, forma_pago, descuento, total, fecha) 
                VALUES (:numero_venta, :usuario_id, :cliente_id, :forma_pago, :descuento, :total, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'numero_venta' => $nuevoNumeroVenta,
                'usuario_id' => $data['usuario_id'] ?? null,
                'cliente_id' => $data['cliente_id'] ?? null,
                'forma_pago' => $data['forma_pago'] ?? '',
                'descuento'  => $data['descuento'] ?? 0.00,
                'total'      => $data['total'] ?? 0.0
            ]);
            $this->lastInsertedId = (int)$this->conn->lastInsertId();
    }

    public function getLastInsertedId(): ?int {
        return $this->lastInsertedId;
    }

    public function load(int $id): array{
        $sql = "SELECT v.id, v.numero_venta, v.usuario_id, v.cliente_id, v.forma_pago, v.descuento, v.total, c.nombre as cliente_nombre, v.fecha, u.nombre as usuario_nombre
        FROM {$this->table} as v 
        INNER JOIN usuarios as u ON v.usuario_id = u.id
        INNER JOIN clientes as c ON v.cliente_id = c.id
        WHERE v.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function update(array $data): void{
        
    }


    public function delete(int $id): void{
        try{
            $this->conn->beginTransaction();

            $sql_buscar = "SELECT item_id, cantidad FROM ventas_detalle WHERE venta_id = :id";
            $stmt_buscar = $this->conn->prepare($sql_buscar);
            $stmt_buscar->execute([
                ':id' => $id
            ]);
            $detalles = $stmt_buscar->fetchAll(\PDO::FETCH_ASSOC) ?: [];

            $sql_restock = "UPDATE items SET stock = stock + :cantidad WHERE id = :item_id";
            $stmt_restock = $this->conn->prepare($sql_restock);

            foreach ($detalles as $item){
                $stmt_restock->execute([
                    ':cantidad' => $item['cantidad'],
                    ':item_id' => $item['item_id']
                ]);
            }

            $sql_detalle = "DELETE FROM ventas_detalle WHERE venta_id = :id";
            $stmt_detalle = $this->conn->prepare($sql_detalle);
            $stmt_detalle->execute([
                ':id' => $id 
            ]);
            $sql_venta = "DELETE FROM {$this->table} where id = :id";
            $stmt_venta = $this->conn->prepare($sql_venta);
            $stmt_venta->execute([
                ':id' => $id
            ]);

            $this->conn->commit();
        }
        catch(\Exception $e){
            if($this->conn->inTransaction()){
                $this->conn->rollBack();
            }
            throw new \Exception("Error al eliminar la venta: " . $e->getMessage());
        }
    }

    public function list(array $filters): array{
        $limit = (int)($filters['limit'] ?? 10);
        $page = (int)($filters['page'] ?? 1);
        $offset = ($page - 1) * $limit;

        $buscar = $filters['buscar'] ?? '';
        $inicio = $filters['fecha_inicio'] ?? '';
        $fin = $filters['fecha_fin'] ?? '';

        $whereClauses = [];
        $params = [];

        if (!empty($buscar)) {
            $whereClauses[] = "u.nombre LIKE :buscar";
            $params[':buscar'] = "%$buscar%";
        }

        if (!empty($inicio) && !empty($fin)) {
            $whereClauses[] = "v.fecha BETWEEN :inicio AND :fin";
            $params[':inicio'] = $inicio . ' 00:00:00';
            $params[':fin'] = $fin . ' 23:59:59';
        } else {
            if (!empty($inicio)) {
                $whereClauses[] = "v.fecha >= :inicio";
                $params[':inicio'] = $inicio . ' 00:00:00';
            }
            if (!empty($fin)) {
                $whereClauses[] = "v.fecha <= :fin";
                $params[':fin'] = $fin . ' 23:59:59';
            }
        }

        $whereSql = "";
        if (count($whereClauses) > 0) {
            $whereSql = " WHERE " . implode(" AND ", $whereClauses);
        }

        $sqlCount = "SELECT COUNT(*) as total 
                FROM {$this->table} v
                INNER JOIN usuarios u ON v.usuario_id = u.id" . $whereSql;

        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $sqlData = "SELECT v.id, v.numero_venta, v.usuario_id, v.cliente_id, v.forma_pago, v.descuento, v.total, v.fecha,
                       u.nombre AS usuario_nombre
                FROM {$this->table} v
                INNER JOIN usuarios u ON v.usuario_id = u.id
                " . $whereSql . "
                ORDER BY v.id DESC
                LIMIT :limit OFFSET :offset";

        $stmtData = $this->conn->prepare($sqlData);

        foreach ($params as $key => $val) {
            $stmtData->bindValue($key, $val);
        }
        $stmtData->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmtData->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmtData->execute();

        $records = $stmtData->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        return [
            'records' => $records,
            'meta' => [
                'total_records' => $totalRecords,
                'current_page' => $page,
                'limit' => $limit,
                'total_pages' => ceil($totalRecords / $limit)
            ]
        ];
    }

}
