<?php 

namespace app\core\services;

use app\core\models\dto\UserDto;
use app\core\models\dao\UserDao;
use app\core\services\base\BaseService;
use app\libs\database\Connection;

final class UserService extends BaseService{

    function __construct(){
        parent::__construct(new UserDao(Connection::get()));
    }

    public function save(UserDto $dto){
        $this->validate($dto);
        $this->dao->save($dto->toArrayForSave());
    }

    public function list(array $filters = []){
        $listaAnidada = $this->dao->list($filters);
        $listaDTOs = [];
        forEach($listaAnidada as $usuario){
            $listaDTOs = new UserDto($usuario);
        }
        return $listaDTOs;
    }

    public function load(int $id): ?UserDto{
        $userData = $this->dao->load($id);
        if(!$userData){
            return null;
        }

        return new UserDto($userData);
    }

    public function update(UserDto $dto){
        $this->dao->update($dto->toArray());
    }

    public function delete(int $id){
        if($id === 1){
            throw new \Exception("No puede borrarse al administrador principal del sistema");
        }

        $this->dao->delete($id);
    }

    private function validate(UserDto $dto): void{
        if($dto->getNombre() == ""){
            throw new \Exception("El campo <strong>nombre</strong> es obligatorio");
        }
        if($dto->getPerfil() == ""){
            throw new \Exception("Debe especificar el <strong>perfil</strong> de la cuenta.");
        }
        if($dto->getCuenta() == ""){
            throw new \Exception("El campo <strong>cuenta</strong> es obligatorio");
        }
        if($dto->getCorreo() == ""){
            throw new \Exception("No se especificó una dirección de <strong>correo</strong> válida");
        }
        if($dto->getContraseña() == ""){
            throw new \Exception("No se especificó una <strong>contraseña</strong> válida");
        }
        
    }
}
