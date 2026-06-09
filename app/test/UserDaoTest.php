<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Cargamos las dependencias necesarias de tu arquitectura
require_once '../config/database.php';
require_once '../libs/database/Connection.php';
require_once '../core/models/dao/base/InterfaceDao.php';
require_once '../core/models/dao/base/BaseDao.php';
require_once '../core/models/dao/UserDao.php';

// 2. ¡OJO! Cargamos el archivo de tu librería de contraseñas
require_once '../libs/password/Password.php'; 

use app\core\models\dao\UserDao;
use app\libs\password\Password; // <-- Importamos tu librería

try {
    $db = app\libs\database\Connection::get();
    $dao = new UserDao($db);

    echo "<h3>Estructura e infraestructura listas...</h3>";

    // 3. Ejecutamos el guardado usando TU componente estático
    $dao->save([
        'id'         => 0,
        'nombre'     => 'Miguel Fernandez',
        'cuenta'     => 'miguel.seguro',
        'perfil'     => 1, 
        'correo'     => 'miguel.seguro@prueba.com',
        
        // --- AQUÍ USAMOS TU LIBRERÍA ---
        'contraseña' => Password::hash('miclave123'), 
        // ------------------------------
        
        'fechaAlta'  => date('Y-m-d'),
        'estado'     => 1,
        'resetPass'  => 0
    ]);
    
    echo '<h2>✔️ ¡Usuario registrado con éxito usando tu librería Password!</h2>';

} catch (\Throwable $ex) {
    echo '<h2>❌ El test falló:</h2>';
    echo '<p><b>Mensaje:</b> ' . $ex->getMessage() . '</p>';
}