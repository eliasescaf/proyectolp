<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ClientDao extends BaseDao implements InterfaceDao {

    public function __construct(protected \PDO $conn) {
        parent::__construct($conn, "clientes");
    }

    public function load(int $id): array {
        $sql = "SELECT id, nombre, tipo, dni, telefono, email, razon_social AS razon, cuit_cuil AS cuit, estado, fecha_alta AS fechaAlta
        FROM {$this->table}
        WHERE id = :id
        LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} (nombre, tipo, dni, telefono, email, razon_social, cuit_cuil, fecha_alta) 
                VALUES (:nombre, :tipo, :dni, :telefono, :email, :razon, :cuit, NOW())";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':nombre'    => $data['nombre'],
            ':tipo'      => $data['tipo'],
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
                    tipo = :tipo,
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
            ':tipo'      => $data['tipo'],
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

        $tipo = $filters['tipo'] ?? '';
        $buscar = $filters['buscar'] ?? '';

        $whereClauses = [];
        $params = [];
        
        if (!empty($tipo)) {
            $whereClauses[] = "tipo = :tipo";
            $params[':tipo'] = $tipo;
        }

        if (!empty($buscar)) {
            $whereClauses[] = "(nombre LIKE :buscar OR razon_social LIKE :buscar OR dni LIKE :buscar OR cuit_cuil LIKE :buscar)";
            $params[':buscar'] = "%$buscar%";
        }

        $whereSql = "";
        if (count($whereClauses) > 0) {
            $whereSql = " WHERE " . implode(" AND ", $whereClauses);
        }

        $sqlCount = "SELECT COUNT(*) as total FROM {$this->table} {$whereSql}";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $sqlData = "SELECT id, tipo, nombre, dni, telefono, email, razon_social AS razon, cuit_cuil AS cuit, estado, fecha_alta AS fechaAlta 
                FROM {$this->table}
                {$whereSql}
                ORDER BY id DESC
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