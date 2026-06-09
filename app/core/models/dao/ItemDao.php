<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ItemDao extends BaseDao implements InterfaceDao {

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

        $result = $stmt->fetch();

        return $result ? $result : null;
    }

    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} (nombre, codigo, riego, descripcion, categoria, precio, stock, estado, fechaAlta) 
                VALUES (:nombre, :codigo, :riego, :descripcion, :categoria, :precio, :stock, :estado, :fechaAlta)";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':codigo' => $data['codigo'],
            ':riego'      => $data['riego'],
            ':descripcion'      => $data['descripcion'],
            ':categoria'      => $data['categoria'],
            ':precio' => $data['precio'], 
            ':stock'   => $data['stock'],
            ':estado'      => $data['estado'],
            ':fechaAlta'   => $data['fechaAlta']
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
            ':id' => $data['id'],
            ':nombre' => $data['nombre'],
            ':riego' => $data['riego'],
            ':descripcion' => $data['descripcion'],
            ':categoria' => $data['categoria'],
            ':precio' => $data['precio'],
            ':stock' => $data['stock'],
            ':estado' => $data['estado']
        ]);
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM {$this->table} where id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function list(array $filters): array {
        $sql = "SELECT id, nombre, codigo, riego, descripcion, categoria, precio, stock, estado, fechaAlta FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}