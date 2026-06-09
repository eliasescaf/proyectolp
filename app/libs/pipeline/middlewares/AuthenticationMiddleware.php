<?php

namespace app\libs\pipeline\middlewares;

use app\libs\database\Connection;
use app\libs\pipeline\middlewares\base\Middleware;
use app\libs\pipeline\middlewares\base\InterfaceMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;
use Override;

final class AuthenticationMiddleware extends Middleware implements InterfaceMiddleware{
    public function __construct(){
        return parent::__construct();
    }

    public function process(Request $request, Response $response): void{
        session_start();

        if(isset($_SESSION["token"]) && ($_SESSION["token"] === APP_TOKEN)){
            if($_SESSION["motivoCierreSesion"] != 0){
                $request->setController(APP_AUTHENTICATION_CONTROLLER);
                $request->setAction(APP_LOGOUT_ACTION);
            }
        else{
            $request->setController(APP_AUTHENTICATION_CONTROLLER);
            if($request->getAction() != APP_LOGIN_ACTION){
                $request->setAction(APP_DEFAULT_ACTION);
                }
            }
        }
    }
}