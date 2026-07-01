<?php

namespace app\core\models\dto;

use app\libs\password\Password;
use app\core\models\enums\UserProfile;

final class UserDto {
    private string $nombre, $cuenta, $contraseña, $correo, $fechaAlta;
    private int $id, $perfil, $estado, $resetPass;

    public function __construct(array $data = []) {
        $this->setId($data['id'] ?? 0);
        $this->setNombre($data['nombre'] ?? "");
        $this->setCuenta($data['cuenta'] ?? "");
        
        $this->setPerfil((int)($data['perfil'] ?? 1));
        
        $this->setContraseña($data['contraseña'] ?? ""); 
        $this->setCorreo($data['correo'] ?? "");
        
        $estadoOriginal = $data['estado'] ?? 1;
        if ($estadoOriginal === "Activo") { $estadoOriginal = 1; }
        if ($estadoOriginal === "Inactivo") { $estadoOriginal = 0; }
        $this->setEstado((int)$estadoOriginal);

        $this->setFechaAlta($data['fechaAlta'] ?? date("Y-m-d"));
        $this->setResetPass($data['resetPass'] ?? 0);
    }

    /** GETTERS */
    public function getId(): int { return $this->id; }
    public function getEstado(): int { return $this->estado; }
    public function getResetPass(): int { return $this->resetPass; }
    public function getNombre(): string { return $this->nombre; }
    public function getCuenta(): string { return $this->cuenta; }
    public function getPerfil(): int { return $this->perfil; }
    public function getContraseña(): string { return $this->contraseña; }
    public function getCorreo(): string { return $this->correo; }
    public function getFechaAlta(): string { return $this->fechaAlta; }

    /** SETTERS */
    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setEstado(int $estado): void {
        $this->estado = ($estado === 0 || $estado === 1) ? $estado : 1;
    }

    public function setResetPass(int $resetPass): void {
        $this->resetPass = ($resetPass === 0 || $resetPass === 1) ? $resetPass : 0;
    }

    public function setNombre(string $nombre): void {
        $nombreTrimeado = trim($nombre);
        $this->nombre = (strlen($nombreTrimeado) > 0 && strlen($nombreTrimeado) <= 100) ? $nombreTrimeado : "";
    }

    public function setCuenta(string $cuenta): void {
        $cuentaTrimeado = trim($cuenta);
        $this->cuenta = (strlen($cuentaTrimeado) > 0 && strlen($cuentaTrimeado) <= 50) ? $cuentaTrimeado : "";
    }

    public function setPerfil(int $perfil): void {
        $perfilesValidos = array_column(UserProfile::cases(), "value");
        $this->perfil = in_array($perfil, $perfilesValidos) ? $perfil : 1;
    }

    public function setContraseña(string $contraseña): void {
        $passTrimeada = trim($contraseña);
        if (strlen($passTrimeada) > 0) {
            $this->contraseña = (strlen($passTrimeada) === 60) ? $passTrimeada : Password::hash($passTrimeada);
        } else {
            $this->contraseña = "";
        }
    }

    public function setCorreo(string $correo): void {
        $this->correo = (strlen(trim($correo)) > 0 && strlen($correo) <= 100) ? trim($correo) : "";
    }

    public function setFechaAlta(string $fechaAlta): void {
        $this->fechaAlta = (strlen($fechaAlta) === 10) ? $fechaAlta : date("Y-m-d");
    }

    public static function validarFormatoLogin(string $cuenta, string $password): void {
        $cuentaTrimeada = trim($cuenta);
        
        if (empty($cuentaTrimeada) || empty($password)) {
            throw new \Exception("Por favor, complete todos los campos obligatorios");
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $cuentaTrimeada)) {
            throw new \Exception("El usuario solo puede contener letras y números, sin espacios ni caracteres especiales");
        }

        if (strlen($password) < 8) {
            throw new \Exception("La contraseña debe tener un mínimo de 8 caracteres");
        }
    }

    public function toArray() {
        return [
            'id'         => $this->getId(),
            'nombre'     => $this->getNombre(),
            'cuenta'     => $this->getCuenta(),
            'perfil'     => $this->getPerfil(),     
            'contraseña' => $this->getContraseña(), 
            'correo'     => $this->getCorreo(),
            'estado'     => $this->getEstado(), 
            'fechaAlta'  => $this->getFechaAlta(),
            'resetPass'  => $this->getResetPass()
        ];
    }

    public function toArrayForSave() {
        return [
            'nombre'     => $this->getNombre(),
            'cuenta'     => $this->getCuenta(),
            'perfil'     => $this->getPerfil(),
            'contraseña' => $this->getContraseña(),
            'correo'     => $this->getCorreo()
        ];
    }
}