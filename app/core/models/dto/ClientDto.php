<?php

namespace app\core\models\dto;

use app\core\models\enums\TipoCliente;

final class ClientDto {
    private string $nombre, $tipo, $dni, $telefono, $email, $razon, $cuit, $fechaAlta;
    private int $id, $estado;

    public function __construct(array $data = []) {
        $this->setId($data['id'] ?? 0);
        $this->setTipo($data['tipo'] ?? "Particular");
        $this->setNombre($data['nombre'] ?? "");
        $this->setDni($data['dni'] ?? "");
        $this->setTelefono($data['telefono'] ?? "");
        $this->setEmail($data['email'] ?? "");
        $this->setRazon($data['razon'] ?? "");
        $this->setCuit($data['cuit'] ?? ""); 

        $estadoOriginal = $data['estado'] ?? 1;
        if ($estadoOriginal === "Activo") { $estadoOriginal = 1; }
        if ($estadoOriginal === "Inactivo") { $estadoOriginal = 0; }
        $this->setEstado((int)$estadoOriginal);

        $this->setFechaAlta($data['fechaAlta'] ?? date("Y-m-d"));
    }

    /** GETTERS */
    public function getId(): int { return $this->id; }
    public function getTipo(): string { return $this->tipo; }
    public function getNombre(): string { return $this->nombre; }
    public function getDni(): string { return $this->dni; }
    public function getTelefono(): string { return $this->telefono; }
    public function getEmail(): string { return $this->email; }
    public function getRazon(): string { return $this->razon; }
    public function getCuit(): string { return $this->cuit; }
    public function getEstado(): int { return $this->estado; }
    public function getFechaAlta(): string { return $this->fechaAlta; }

    /** SETTERS */
    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setNombre(string $nombre): void {
        $nombreTrimeado = trim($nombre);
        $this->nombre = (strlen($nombreTrimeado) > 0 && strlen($nombreTrimeado) <= 100) ? $nombreTrimeado : "";
    }

    public function setTipo(string $tipo): void {
        $categoriaValida = array_column(TipoCliente::cases(), 'value');
        $this->tipo = in_array($tipo, $categoriaValida) ? $tipo : TipoCliente::PARTICULAR->value;
    }

    public function setDni(string $dni): void {
        $dniTrimeado = trim($dni); 
        $this->dni = (strlen($dniTrimeado) > 0 && strlen($dniTrimeado) <= 15) ? $dniTrimeado : "";
    }

    public function setTelefono(string $telefono): void {
        $telefonoTrimeado = trim($telefono);
        $this->telefono = (strlen($telefonoTrimeado) > 0 && strlen($telefonoTrimeado) <= 30) ? $telefonoTrimeado : "";
    }

    public function setEmail(string $email): void {
        $emailTrimeado = trim($email);
        $this->email = (strlen($emailTrimeado) > 0 && strlen($emailTrimeado) <= 100) ? $emailTrimeado : "";
    }

    public function setRazon(string $razon): void {
        $razonTrimeado = trim($razon);
        $this->razon = (strlen($razonTrimeado) > 0 && strlen($razonTrimeado) <= 150) ? $razonTrimeado : "";
    }

    public function setCuit(string $cuit): void {
        $cuitTrimeado = trim($cuit);
        $this->cuit = (strlen($cuitTrimeado) > 0 && strlen($cuitTrimeado) <= 20) ? $cuitTrimeado : "";
    }

    public function setEstado(int $estado): void {
        $this->estado = ($estado === 0 || $estado === 1) ? $estado : 1;
    }

    public function setFechaAlta(string $fechaAlta): void {
        $this->fechaAlta = (strlen($fechaAlta) >= 10) ? $fechaAlta : date("Y-m-d");
    }

    public function toArray(): array {
        return [
            'id'         => $this->getId(),
            'tipo'       => $this->getTipo(),
            'nombre'     => $this->getNombre(),
            'dni'        => $this->getDni(),
            'telefono'   => $this->getTelefono(),
            'email'      => $this->getEmail(),
            'razon'      => $this->getRazon(),
            'cuit'       => $this->getCuit(),
            'estado'     => $this->getEstado(),
            'fechaAlta'  => $this->getFechaAlta()
        ];
    }

    public function toArrayForSave(): array {
        return [
            'nombre'     => $this->getNombre(),
            'tipo'       => $this->getTipo(),
            'dni'        => $this->getDni(),
            'telefono'   => $this->getTelefono(),
            'email'      => $this->getEmail(),
            'razon'      => $this->getRazon(),
            'cuit'       => $this->getCuit(),
        ];
    }
}