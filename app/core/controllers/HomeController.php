<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;

class HomeController extends BaseController{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        $this->breadcrumb = [
            "Inicio" => null,
        ];
        $this->scripts = [
            'app/assets/libs/jspdf.umd.min.js',
            'app/assets/libs/jspdf.plugin.autotable.min.js'
        ];
        $this->modules = [];
        $this->setCurrentView($request);
        require_once(APP_FILE_TEMPLATE);
    }
}