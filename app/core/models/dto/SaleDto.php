<?php

namespace app\core\models\dto;

use app\core\models\dto\SaleDetailDto;

final class SaleDto {
    private int $id;
    private int $usuarioId;
    private ?int $clienteId; 
    private string $formaPago; 
    private float $total;
    private string $fecha;
    private array $detalles; 
    private ?string $usuarioNombre;
    private float $descuento;

    public function __construct(array $data = []) {
        $this->id            = (int)($data['id'] ?? 0);
        $this->usuarioId     = (int)($data['usuario_id'] ?? 0);
        $this->clienteId     = isset($data['cliente_id']) ? (int)$data['cliente_id'] : null;
        $this->formaPago     = $data['forma_pago'] ?? '';
        $this->total         = (float)($data['total'] ?? 0.0);
        $this->fecha         = $data['fecha'] ?? date("Y-m-d H:i:s");
        $this->usuarioNombre = $data['usuario_nombre'] ?? null;
        $this->descuento = (float)($data['descuento'] ?? 0.00);
        
        $this->detalles = [];
        if (isset($data['productos']) && is_array($data['productos'])) {
            foreach ($data['productos'] as $item) {
                $this->detalles[] = new SaleDetailDto($item);
            }
        } elseif (isset($data['detalles']) && is_array($data['detalles'])) {
            foreach ($data['detalles'] as $item) {
                if ($item instanceof SaleDetailDto) {
                    $this->detalles[] = $item;
                } else {
                    $this->detalles[] = new SaleDetailDto($item);
                }
            }
        }
    }

    // --- GETTERS ---
    public function getId(): int { return $this->id; }
    public function getUsuarioId(): int { return $this->usuarioId; }
    public function getClienteId(): ?int { return $this->clienteId; }
    public function getFormaPago(): string { return $this->formaPago; }
    public function getTotal(): float { return $this->total; }
    public function getFecha(): string { return $this->fecha; }
    public function getUsuarioNombre(): ?string { return $this->usuarioNombre; }
    public function getDetalles(): array { return $this->detalles; }
    public function getDescuento(): float  { return $this->descuento; }

    public function setUsuarioId(int $usuarioId): void {
        $this->usuarioId = $usuarioId;
    }


    public function toArray(): array {
        $arrDetalles = [];
        foreach ($this->detalles as $det) {
            $arrDetalles[] = [
                'item_id'     => $det->getItemId(),
                'cantidad'        => $det->getCantidad(),
                'precio_unitario' => $det->getPrecioUnitario(),
                'nombre_item'   => $det->getNombreItem(),
                'subtotal'        => $det->getSubtotal()
            ];
        }

        return [
            'id'             => $this->id,
            'usuario_id'     => $this->usuarioId,
            'usuario_nombre' => $this->usuarioNombre,
            'cliente_id'     => $this->clienteId,
            'forma_pago'     => $this->formaPago,
            'descuento'  => $this->descuento,
            'total'          => $this->total,
            'fecha'          => $this->fecha,
            'detalles'       => $arrDetalles
        ];
    }

    public function toArrayForSave(): array {
        return [
            'usuario_id' => $this->usuarioId,
            'cliente_id' => $this->clienteId,
            'forma_pago' => $this->formaPago,
            'descuento' => $this->descuento,
            'total'      => $this->total
        ];
    }
}