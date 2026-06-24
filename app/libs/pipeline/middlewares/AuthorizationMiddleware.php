<?php

namespace app\libs\pipeline\middlewares;
use app\libs\pipeline\middlewares\base\Middleware;
use app\libs\pipeline\middlewares\base\InterfaceMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;



class AuthorizationMiddleware extends Middleware implements InterfaceMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function process(Request $request, Response $response): void {
        $currentController = $request->getController();

        if ($currentController === 'user') {
            if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 2) {
                $request->setController(APP_DEFAULT_CONTROLLER);
                $request->setAction(APP_DEFAULT_ACTION);
            }
        }

        $this->processNext($request, $response);
    }

}