<?php
namespace app\core\models\dao;

use app\core\models\dto\SaleDto;
use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class SaleDao extends BaseDao{

    public function __construct(protected \PDO $conn){
        parent::__construct($conn, 'ventas');
    }

    public function save(SaleDto $saledto){
        $sql = "INSERT INTO $this->table (usuario_id, total, fecha) VALUES (:usuario_id, :total, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $saledto->usuario_id,
            ':total' => $saledto->total
        ]);
    }
}
