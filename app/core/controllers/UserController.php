<?php

namespace app\core\controllers;

use app\core\controllers\base\BaseController;
use app\libs\http\Request;
use app\libs\http\Response;

class UserController extends BaseController{
    public function __construct(){
        parent::__construct();
    }

    public function index(Request $request, Response $response){
        require_once(APP_FILE_TEMPLATE);
    }

    public function create(Request $request, Response $response){
        require_once(APP_FILE_TEMPLATE);
    }

    public function save(Request $request, Response $response){

    }

    public function edit(Request $request, Response $response){
        require_once(APP_FILE_TEMPLATE);
    }

    public function update(Request $request, Response $response){

    }
}