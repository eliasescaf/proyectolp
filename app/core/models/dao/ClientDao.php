<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ClientDao extends BaseDao implements InterfaceDao {

    public function __construct(protected \PDO $conn) {
        parent::__construct($conn, "clientes");
    }

    public function load(int $id): array {
        $sql = "SELECT id, nombre, dni, telefono, email, razon_social AS razon, cuit_cuil AS cuit, estado, fecha_alta AS fechaAlta
        FROM {$this->table}
        WHERE id = :id
        LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} (nombre, dni, telefono, email, razon_social, cuit_cuil, fecha_alta) 
                VALUES (:nombre, :dni, :telefono, :email, :razon, :cuit, NOW())";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':nombre'    => $data['nombre'],
            ':dni'       => $data['dni'],
            ':telefono'  => $data['telefono'],
            ':email'     => $data['email'],
            ':razon'     => $data['razon'],
            ':cuit'      => $data['cuit'], 
        ]);
    }
        
    public function update(array $data): void {
        $sql = "UPDATE {$this->table}
                SET nombre = :nombre,
                    dni = :dni,
                    telefono = :telefono,
                    email = :email,
                    razon_social = :razon,
                    cuit_cuil = :cuit,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre'    => $data['nombre'],
            ':dni'       => $data['dni'],
            ':telefono'  => $data['telefono'],
            ':email'     => $data['email'],
            ':razon'     => $data['razon'],
            ':cuit'      => $data['cuit'], 
            ':estado'    => $data['estado'],
            ':id'        => $data['id']
        ]);
    }

    public function delete(int $id): void {
        $sqlCheck = "SELECT COUNT(*) FROM ventas WHERE cliente_id = :id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        
        $resultado = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

        if ($resultado && $resultado['COUNT(*)'] > 0) {
            throw new \Exception("No se puede eliminar el cliente porque tiene ventas asociadas. Se recomienda en todo caso, cambiar su estado a Inactivo.");
        }

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function list(array $filters = []): array {
        $limit = (int)($filters['limit'] ?? 10);
        $page = (int)($filters['page'] ?? 1);
        $offset = ($page - 1) * $limit;

        $sqlCount = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute();
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $sqlData = "SELECT id, nombre, dni, telefono, email, razon_social AS razon, cuit_cuil AS cuit, estado, fecha_alta AS fechaAlta 
                FROM {$this->table}
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

    public function suggestive(array $filters): array {
        $sql = "SELECT SQL_CALC_FOUND_ROWS id, nombre, dni, razon_social, cuit_cuil, telefono, email
        FROM {$this->table}";

        $parameters = [];
        $clauses = [];

        $clauses["estado"] = "(estado = 1)";

        if (isset($filters["valueToSearch"]) && trim($filters["valueToSearch"]) !== "") {
            $clauses["valueToSearch"] = "(nombre LIKE :value OR dni LIKE :value OR cuit_cuil LIKE :value)";
            $parameters["value"] = "%" . $filters["valueToSearch"] . "%"; 
        }

        if (count($clauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }

        $sql .= " ORDER BY nombre ASC";
        $sql .= " LIMIT 0, 5"; 

        return $this->selectQuery($sql, $parameters);
    }
}