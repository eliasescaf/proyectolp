<?php

namespace app\libs\pipeline\middlewares;
use app\libs\pipeline\middlewares\base\Middleware;
use app\libs\pipeline\middlewares\base\InterfaceMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;

/**
 * Descripción de RouterMiddleware
 *
 * @author Ing. Jose Rasjido
 */
final class RouterMiddleware extends Middleware implements InterfaceMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function process(Request $request, Response $response): void {
        $controller = ucfirst($request->getController()) . "Controller";
        $controller = "app\\core\\controllers\\" . $controller;

        //"app\core\controller\ItemController"
        
        if(!class_exists($controller) || !method_exists($controller, $request->getAction())){
            throw new \Exception("Controlador y acción incorrectos ({$request->getController()} => {$request->getAction()})");
        }
        
        //Se invoca el endpoint
        call_user_func_array(
            array(new $controller, $request->getAction()),
            array($request, $response)
            );
    }
}