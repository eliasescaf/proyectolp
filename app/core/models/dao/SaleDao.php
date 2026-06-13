<?php
namespace app\core\models\dao;

use app\core\models\dto\SaleDto;
use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class SaleDao extends BaseDao implements InterfaceDao{

    public function __construct(protected \PDO $conn){
        parent::__construct($conn, 'ventas');
    }

    public function save(array $data): void{
        $sql = "INSERT INTO $this->table (usuario_id, total, fecha) VALUES (:usuario_id, :total, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $data['usuario_id'],
            ':total' => $data['total']
        ]);
    }

    public function load(int $id): array{
        return [];
    }

    public function update(array $data): void{

    }


    public function delete(int $id): void{

    }

    public function list(array $filters): array{
        return [];
    }

}
