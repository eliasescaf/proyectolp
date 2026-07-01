<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ItemDao extends BaseDao implements InterfaceDao{

    public function __construct(protected \PDO $conn) {
        parent::__construct($conn, "items");
    }

    public function load(int $id): array {
        $sql = "SELECT id, nombre, codigo, riego, descripcion, categoria, precio, stock, estado, fechaAlta
        FROM {$this->table}
        WHERE id = :id
        LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];

        return $result ? $result : [];
    }

    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} (nombre, codigo, riego, descripcion, categoria, precio, stock, fechaAlta) 
                VALUES (:nombre, :codigo, :riego, :descripcion, :categoria, :precio, :stock, NOW())";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':codigo' => $data['codigo'],
            ':riego'      => $data['riego'],
            ':descripcion'      => $data['descripcion'],
            ':categoria'      => $data['categoria'],
            ':precio' => $data['precio'], 
            ':stock'   => $data['stock'],
        ]);
    }
        
    public function update(array $data): void {
        $sql = "UPDATE {$this->table}
                SET nombre = :nombre,
                    codigo = :codigo,
                    riego = :riego,
                    descripcion = :descripcion,
                    categoria = :categoria,
                    precio = :precio,
                    stock = :stock,
                    estado = :estado
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id'          => $data['id'],
            ':nombre'      => $data['nombre'],
            ':codigo'      => $data['codigo'],
            ':riego'       => $data['riego'],
            ':descripcion' => $data['descripcion'],
            ':categoria'   => $data['categoria'],
            ':precio'      => $data['precio'],
            ':stock'       => $data['stock'],
            ':estado'      => $data['estado'] 
        ]);
    }

    public function delete(int $id): void {
        $sqlCheck = "SELECT COUNT(*) FROM ventas_detalle WHERE item_id = :id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $resultado = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

        if($resultado && $resultado['COUNT(*)'] > 0){
            throw new \Exception("No se puede eliminar el item porque tiene ventas asociadas. Se recomienda en todo caso, cambiar su estado a Discontinuado");
        }
        $sql = "DELETE FROM {$this->table} where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function list(array $filters): array {
        $limit = (int)($filters['limit'] ?? 10);
        $page = (int)($filters['page'] ?? 1);
        $offset = ($page - 1) * $limit;
        $buscar = $filters['buscar'] ?? '';
        $categoria = $filters['categoria'] ?? '';

        $whereClauses = [];
        $params = [];

        if (!empty($buscar)) {
            $whereClauses[] = "(nombre LIKE :buscar OR codigo LIKE :buscar)";
            $params[':buscar'] = "%$buscar%";
        }
        if (!empty($categoria)) {
            $whereClauses[] = "categoria = :categoria";
            $params[':categoria'] = $categoria;
        }

        $whereSql = "";
        if (count($whereClauses) > 0) {
            $whereSql = " WHERE " . implode(" AND ", $whereClauses);
        }

        $sqlCount = "SELECT COUNT(*) as total FROM {$this->table} {$whereSql}";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];


        $sqlData = "SELECT id, nombre, codigo, riego, descripcion, categoria, precio, stock, estado, fechaAlta 
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
        $sql = "SELECT SQL_CALC_FOUND_ROWS id, codigo, nombre, precio, stock, estado
        FROM {$this->table}";

        $parameters = [];
        $clauses = [];

        $clauses["estado"] = "(estado = 1)";

        if (isset($filters["valueToSearch"]) && trim($filters["valueToSearch"]) !== "") {
            $clauses["valueToSearch"] = "(nombre LIKE :value OR codigo LIKE :value)";
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