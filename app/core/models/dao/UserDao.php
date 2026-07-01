<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;
use app\core\models\dto\UserDto;

final class UserDao extends BaseDao implements InterfaceDao{

    public function __construct(protected \PDO $conn) {
        parent::__construct($conn, "usuarios");
    }

    public function load(int $id): array {
        $sql = "SELECT id, nombre, cuenta, perfil, correo, contraseña, fechaAlta, estado, resetPass
        FROM {$this->table}
        WHERE id = :id
        LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    public function save(array $data): void {
        $this->validateCuenta(0, $data['cuenta']);
        $this->validateCorreo(0, $data['correo']);

        $sql = "INSERT INTO {$this->table} (nombre, cuenta, perfil, correo, contraseña, fechaAlta) 
                VALUES (:nombre, :cuenta, :perfil, :correo, :contrasenia, NOW())";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
        ':nombre'      => $data['nombre'],
        ':cuenta'      => $data['cuenta'],
        ':perfil'      => $data['perfil'],
        ':correo'      => $data['correo'],
        ':contrasenia' => $data['contraseña']
        ]);
    }
        
    public function update(array $data): void {
        $this->validateCuenta((int)$data['id'], $data['cuenta']);
        $this->validateCorreo((int)$data['id'], $data['correo']);

        $sql = "UPDATE {$this->table}
        SET nombre = :nombre,
        cuenta = :cuenta,
        perfil = :perfil,
        correo = :correo,
        contraseña = :contrasenia,
        estado = :estado,
        resetPass = :resetPass
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $data['id'],
            ':nombre' => $data['nombre'],
            ':cuenta' => $data['cuenta'],
            ':perfil' => $data['perfil'],
            ':correo' => $data['correo'],
            ':contrasenia' => $data['contraseña'],
            ':estado' => $data['estado'],
            ':resetPass' => $data['resetPass'],
        ]);
    }

    public function login(string $cuenta): array{
        $sql = "SELECT user.id, user.nombre, user.cuenta, user.perfil, user.correo, user.contraseña, user.estado, user.resetPass";
        $sql .= " FROM usuarios AS user";
        $sql .= " WHERE (cuenta = :cuenta OR correo = :cuenta)";
        $result = $this->selectQuery($sql, ["cuenta" => $cuenta]);
        if(count($result) != 1){
            throw new \Exception("El nombre de usuario o la contraseña no coinciden");
        }
        return $result[0];
    }

    public function updatePassword(array $data): void{
        $sql = "UPDATE {$this->table} 
                SET contraseña = :contrasenia 
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id'          => $data['id'],
            ':contrasenia' => $data['contraseña'] 
        ]);
    }

    public function delete(int $id): void {
        $sqlCheck = "SELECT COUNT(*) FROM ventas WHERE usuario_id = :id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $resultado = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

        if($resultado && $resultado['COUNT(*)'] > 0){
            throw new \Exception("No se puede eliminar el usuario porque tiene ventas asociadas. Se recomienda en todo caso, cambiar su estado a Discontinuado");
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
        $perfil = $filters['perfil'] ?? '';

        $whereClauses = [];
        $params = [];

        if (!empty($buscar)) {
            $whereClauses[] = "(nombre LIKE :buscar OR cuenta LIKE :buscar OR correo LIKE :buscar)";
            $params[':buscar'] = "%$buscar%";
        }
        if (!empty($perfil)) {
            $whereClauses[] = "perfil = :perfil";
            $params[':perfil'] = $perfil;
        }

        $whereSql = "";
        if (count($whereClauses) > 0) {
            $whereSql = " WHERE " . implode(" AND ", $whereClauses);
        }

        $sqlCount = "SELECT COUNT(*) as total FROM {$this->table} {$whereSql}";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = (int)$stmtCount->fetch(\PDO::FETCH_ASSOC)['total'];

        $sqlData = "SELECT id, nombre, cuenta, perfil, correo, contraseña, fechaAlta, estado, resetPass 
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

    private function validateCuenta(int $id, string $cuenta): void {
        $sql = "SELECT id FROM {$this->table} WHERE cuenta = :cuenta AND id != :id LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':cuenta' => $cuenta,
            ':id'     => $id
        ]);

        if ($stmt->fetch()) {
            throw new \Exception("La cuenta <strong>{$cuenta}</strong> ya está siendo utilizada");
        }
    }

    private function validateCorreo(int $id, string $correo): void {
        $sql = "SELECT id FROM {$this->table} WHERE correo = :correo AND id != :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id'     => $id,
            'correo' => $correo
        ]);
        if($stmt->fetch()){
            throw new \Exception("El correo {$correo} ya esta siendo usado por otro usuario.");
        }
    }
}