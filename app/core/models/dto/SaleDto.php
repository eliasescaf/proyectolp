<?php

namespace app\core\models\dto;

final class SaleDto {
    private int $id, $usuarioId;
    private float $total;
    private string $fecha;

    public function __construct(array $data = []) {
        $this->setId($data['id'] ?? 0);
        $this->setUsuarioId($data['usuario_id'] ?? 0);
        $this->setTotal((float)($data['total'] ?? "0.0"));
        $this->setFecha($data['fecha'] ?? date("Y-m-d H:i:s"));
    }

    public function getId(): int { return $this->id; }
    public function getUsuarioId(): int { return $this->usuarioId; }
    public function getTotal(): float { return $this->total; }
    public function getFecha(): string { return $this->fecha; }

    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setUsuarioId(int $usuarioId): void {
        $this->usuarioId = ($usuarioId > 0) ? $usuarioId : 0;
    }

    public function setTotal(float $total): void {
        $this->total = ($total >= 0) ? $total : 0.0;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = (strlen($fecha) >= 10) ? $fecha : date("Y-m-d H:i:s");
    }

    
    public function toArray(): array {
        return [
            'id'         => $this->getId(),
            'usuario_id' => $this->getUsuarioId(),
            'total'      => $this->getTotal(),
            'fecha'      => $this->getFecha()
        ];
    }

    public function toArrayForSave(): array {
        return [
            'usuario_id' => $this->getUsuarioId(),
            'total'      => $this->getTotal(),
        ];
    }
}