<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\core\services\AuthenticationService;
use app\libs\http\Request;
use app\libs\http\Response;

class AuthenticationController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        $this->setCurrentView($request);
        require_once(APP_DIR_TEMPLATE . 'auth_template.php');
    }

    public function login(Request $request, Response $response){
        try {
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';
            
            $service = new AuthenticationService();
            $service->login($user, $pass);
            
            $request->setController(APP_DEFAULT_CONTROLLER); 
            $request->setAction(APP_DEFAULT_ACTION);         
            
            $this->setCurrentView($request);
            require_once(APP_FILE_TEMPLATE);
            
        } catch (\Exception $e) {
            $response->setMessage($e->getMessage());
            $this->setCurrentView($request);
            require_once(APP_DIR_TEMPLATE . 'auth_template.php');
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