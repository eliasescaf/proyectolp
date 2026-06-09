<?php

namespace app\core\models\dto;

class SaleDto{
    public int $usuario_id;
    public float $total;
    public array $productos;

    public function __construct(int $usuario_id, float $total, array $productos = []){
        $this->usuario_id = $usuario_id;
        $this->total = $total;
        $this->productos = $productos;
    }
}