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

        $result = $stmt->fetch();

        return $result ? $result : null;
    }

    public function save(array $data): void {
        $this->validateCuenta(0, $data['cuenta']);
        $this->validateCorreo(0, $data['correo']);

        $sql = "INSERT INTO {$this->table} (nombre, cuenta, perfil, correo, contraseña) 
                VALUES (:nombre, :cuenta, :perfil, :correo, :contrasenia)";
                
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
        $sql = "UPDATE {$this->table}";
        $sql = " SET contraseña =: contraseña";
        $sql = " WHERE id = :id";
        $this->updateQuery($sql, $data);
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM {$this->table} where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function list(array $filters): array {
        $sql = "SELECT id, nombre, cuenta, perfil, correo, contraseña, fechaAlta, estado, resetPass FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private function validateCuenta(int $id, string $cuenta): void {
        $sql = "SELECT id FROM {$this->table} WHERE cuenta = :cuenta AND id != :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute([
            'id' => $id,
            'cuenta' => $cuenta
        ]);
        if($stmt->rowCount() != 0){
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
        if($stmt->rowCount() != 0){
            throw new \Exception("El correo {$correo} ya esta siendo usado por otro usuario.");
        }
    }
}