<?php

namespace app;

use app\libs\pipeline\Pipeline;
use app\libs\pipeline\middlewares\ExceptionHandlerMiddleware;
use app\libs\pipeline\middlewares\AuthenticationMiddleware;
use app\libs\pipeline\middlewares\RouterMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;

final class App{

    private function __construct(){}
    
    public static function run(){
        $pipeline = new Pipeline();
        
        $pipeline->pipe(new ExceptionHandlerMiddleware())
        ->pipe(new RouterMiddleware());
        
        $pipeline->process(new Request(), new Response());
    }
    
}