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
        $sql = "INSERT INTO {$this->table} (usuario_id, cliente_id, forma_pago, descuento, total, fecha) 
                VALUES (:usuario_id, :cliente_id, :forma_pago, :descuento, :total, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
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
        $sql = "SELECT v.id, v.usuario_id, v.cliente_id, v.forma_pago, v.descuento, v.total, v.fecha, u.nombre as usuario_nombre
        FROM {$this->table} as v 
        INNER JOIN usuarios as u ON v.usuario_id = u.id
        WHERE v.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function update(array $data): void{
        
    }


    public function delete(int $id): void{

    }

    public function list(array $filters): array{
        $limit = (int)($filters['limit'] ?? 10);
        $page = (int)($filters['page'] ?? 1);
        $offset = ($page - 1) * $limit;

        $sqlCount = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute();
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $sqlData = "SELECT v.id, v.usuario_id, v.cliente_id, v.forma_pago, v.descuento, v.total, v.fecha,
                       u.nombre AS usuario_nombre
                FROM {$this->table} v
                INNER JOIN usuarios u ON v.usuario_id = u.id
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";
        $stmtData = $this->conn->prepare($sqlData);
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
                'total_pages' => ceil($totalRecords/$limit)
            ]
        ];
    }

}
