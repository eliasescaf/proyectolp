<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\services\AuthenticationService;
use app\libs\http\Request;
use app\libs\http\Response;

class AuthenticationController extends BaseController{
    protected string $errorLogin = "";
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js',
            'app/js/authentication/login.js'
        ];
        $this->errorLogin = "";
        $this->setCurrentView($request);
        require_once(APP_DIR_TEMPLATE . 'auth_template.php');
    }

    public function login(Request $request, Response $response){
        try {

            $this->errorLogin = ""; 
            $user = $request->getParameterValue('usuario-data', '');
            $pass = $request->getParameterValue('password-data', '');

            if(empty($user) || empty($pass)){
                throw new \Exception("Debe ingresar un usuario y una contraseña.");
            }
            
            $service = new AuthenticationService();
            $service->login($user, $pass);
            
            $response->setMessage("Autenticación exitosa. Redirigiendo...");
            $response->setData([]);
            $response->send(true);   
            
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $response->setData([]);
            $response->send(false);
        }
    }

    public function logout(Request $request, Response $response){
        $service = new AuthenticationService();
        $service->logout();
        $request->setController('authentication');
        $request->setAction('index');
        $this->setCurrentView($request);
        
        require_once(APP_DIR_TEMPLATE . 'auth_template.php');
    }

}