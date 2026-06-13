<?php
    
    namespace app\core\models\dao\base;

    class BaseDao{

        public function __construct(protected \PDO $conn, protected string $table){
        }

        protected function selectQuery(string $sql, array $params): array{
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    protected function insertQuery(string $sql, array $params): void{
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $stmt->closeCursor();
    }

    protected function updateQuery(string $sql, array $params){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $stmt->closeCursor();
    }

    public function deleteQuery(int $id): void{
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array("id" => $id));
        if($stmt->rowCount() !== 1){
            throw new \Exception("No se pudo eliminar el registro con el identificador ({$id})");
        }
        $stmt->closeCursor();
    }
}