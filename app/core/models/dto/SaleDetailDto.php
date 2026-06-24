<?php

namespace app\core\models\dto;

final class SaleDetailDto {

    private ?int $id;
    private int $ventaId;
    private int $itemId;
    private int $cantidad;
    private float $precioUnitario;
    private ?string $nombreItem;
    private ?float $subtotal;

    public function __construct(array $data) {
        $this->id             = isset($data['id']) ? (int)$data['id'] : null;
        $this->ventaId        = (int)($data['venta_id'] ?? 0);
        $this->itemId     = (int)($data['item_id'] ?? 0);
        $this->cantidad       = (int)($data['cantidad'] ?? 0);
        $this->precioUnitario = (float)($data['precio_unitario'] ?? 0.00);
        $this->nombreItem   = $data['nombre_item'] ?? null;
        $this->subtotal       = isset($data['subtotal']) ? (float)$data['subtotal'] : ($this->cantidad * $this->precioUnitario);
    }

    // --- GETTERS ---
    public function getId(): ?int { return $this->id; }
    public function getVentaId(): int { return $this->ventaId; }
    public function getItemId(): int { return $this->itemId; }
    public function getCantidad(): int { return $this->cantidad; }
    public function getPrecioUnitario(): float { return $this->precioUnitario; }
    public function getNombreItem(): ?string { return $this->nombreItem; }
    public function getSubtotal(): float { return $this->subtotal; }


    public function setVentaId(int $ventaId): void {
        $this->ventaId = $ventaId;
    }

    public function toArrayForSave(): array {
        return [
            'venta_id'        => $this->ventaId,
            'item_id'     => $this->itemId,
            'nombre_item' => $this->nombreItem,
            'cantidad'        => $this->cantidad,
            'precio_unitario' => $this->precioUnitario
        ];
    }
}