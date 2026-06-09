<?php
    
    namespace app\core\models\dao\base;

    class BaseDao{

        public function __construct(protected \PDO $conn, protected string $table){
        }
    }