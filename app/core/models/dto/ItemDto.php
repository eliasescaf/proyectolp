<?php

namespace app\core\models\dto;

use app\core\models\enums\PlantCategory;
use app\core\models\enums\PlantWatering;

final class ItemDto {
    private string $nombre, $codigo, $descripcion, $fechaAlta;
    private int $id, $riego, $categoria,$estado, $stock;
    private float $precio;

    public function __construct(array $data = []) {
        $this->setId($data['id'] ?? 0);
        $this->setNombre($data['nombre'] ?? "");
        $this->setCodigo($data['codigo'] ?? "");
        $this->setDescripcion($data['descripcion'] ?? "");
        $this->setRiego((int)($data['riego'] ?? 1));
        $this->setCategoria((int)($data['categoria'] ?? 1));
        $this->setStock((int)($data['stock'] ?? 0)); 
        $this->setPrecio((float)($data['precio'] ?? "0.0"));
        
        $estadoOriginal = $data['estado'] ?? 1;
        if ($estadoOriginal === "Activo") { $estadoOriginal = 1; }
        if ($estadoOriginal === "Discontinuo") { $estadoOriginal = 0; }
        $this->setEstado((int)$estadoOriginal);

        $this->setFechaAlta($data['fechaAlta'] ?? date("Y-m-d"));
    }

    /** GETTERS */
    public function getId(): int { return $this->id; }
    public function getCodigo(): string { return $this->codigo; }
    public function getEstado(): int { return $this->estado; }
    public function getPrecio(): float { return $this->precio; }
    public function getNombre(): string { return $this->nombre; }
    public function getStock(): int { return $this->stock; }
    public function getDescripcion(): string { return $this->descripcion; }
    public function getRiego(): int { return $this->riego; }
    public function getCategoria(): int { return $this->categoria; }
    public function getFechaAlta(): string { return $this->fechaAlta; }

    /** SETTERS */
    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setCodigo(string $codigo): void {
        $codigoTrimeado = strtoupper(trim($codigo)); 
        $this->codigo = (strlen($codigoTrimeado) > 0 && strlen($codigoTrimeado) <= 10) ? $codigoTrimeado : "";
    }

    public function setEstado(int $estado): void {
        $this->estado = ($estado === 0 || $estado === 1) ? $estado : 1;
    }

    public function setStock(int $stock): void {
        $this->stock = ($stock >= 0) ? $stock : 0;
    }

    public function setNombre(string $nombre): void {
        $nombreTrimeado = trim($nombre);
        $this->nombre = (strlen($nombreTrimeado) > 0 && strlen($nombreTrimeado) <= 100) ? $nombreTrimeado : "";
    }

    public function setDescripcion(string $descripcion): void {
        $descripcionTrimeado = trim($descripcion);
        $this->descripcion = (strlen($descripcionTrimeado) > 0 && strlen($descripcionTrimeado) <= 255) ? $descripcionTrimeado : "";
    }

    public function setPrecio(float $precio): void {
        $this->precio = ($precio >= 0) ? $precio : 0.0;
    }

    public function setCategoria(int $categoria): void {
        $categoriasValidas = array_column(PlantCategory::cases(), "value");
        $this->categoria = in_array($categoria, $categoriasValidas) ? $categoria : PlantCategory::INTERIOR->value;
    }

    public function setRiego(int $riego): void {
        $riegosValidos = array_column(PlantWatering::cases(), "value");
        $this->riego = in_array($riego, $riegosValidos) ? $riego : PlantWatering::BAJO->value;
    }

    public function setFechaAlta(string $fechaAlta): void {
        $this->fechaAlta = (strlen($fechaAlta) === 10) ? $fechaAlta : date("Y-m-d");
    }

    public function toArray() {
        return [
            'id'         => $this->getId(),
            'nombre'     => $this->getNombre(),
            'codigo'      => $this->getCodigo(),
            'riego'     => $this->getRiego(),
            'descripcion'     => $this->getDescripcion(),     
            'categoria' => $this->getCategoria(), 
            'precio'     => $this->getPrecio(),
            'stock'     => $this->getStock(), 
            'estado'  => $this->getEstado(),
            'fechaAlta'  => $this->getFechaAlta()
        ];
    }

    public function toArrayForSave() {
        return [
            'nombre'     => $this->getNombre(),
            'codigo'      => $this->getCodigo(),
            'riego'     => $this->getRiego(),
            'descripcion'     => $this->getDescripcion(),
            'categoria' => $this->getCategoria(),
            'precio'     => $this->getPrecio(),
            'stock'     => $this->getStock()
        ];
    }
}