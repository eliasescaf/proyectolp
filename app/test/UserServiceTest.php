<?php

require_once '../config/appconfig.php';
require_once '../config/database.php';
require_once '../vendor/autoload.php';

use app\core\models\dto\UserDto;
use app\core\services\UserService;
use app\core\models\enums\UserProfile;

try{
    $service = new UserService();
    $dto = new UserDto([
        'id'         => 0,
        'nombre'     => 'Jorge Molina',             
        'cuenta'     => 'jorge.irina',
        'perfil'     => 1,
        'contraseña' => 'miclave999',               
        'correo'     => 'jorge@gmail.com',
        'estado'     => 1,
        'fechaAlta'  => date('Y-m-d'),
        'resetPass'  => 0
    ]);
    $service->save($dto);
    echo 'Usuario registrado con éxito';
}
catch(\PDOException $ex){
    echo 'Error inesperado en BD: ' . $ex->getMessage();
}
catch(\Exception $ex){
    echo 'Error inesperado: ' . $ex->getMessage();
}