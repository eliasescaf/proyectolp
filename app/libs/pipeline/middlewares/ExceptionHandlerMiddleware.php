<?php

namespace app\libs\pipeline\middlewares;

use app\libs\database\Connection;
use app\libs\pipeline\middlewares\base\Middleware;
use app\libs\pipeline\middlewares\base\InterfaceMiddleware;
use app\libs\http\Request;
use app\libs\http\Response;

/**
 * Descripción de ExceptionHandleMiddleware
 * Captura las excepciones que puedan ocurrir en el resto de la cadena de responsabilidades.
 *
 * @author Ing. Jose Rasjido
 */

final class ExceptionHandlerMiddleware extends Middleware implements InterfaceMiddleware{
    
    public function __construct() {
        parent::__construct();
    }

    public function process(Request $request, Response $response): void {
        try{
            $this->processNext($request, $response);
        }
        catch (\PDOException $ex) {
            //trigger_error($ex->getMessage(), E_USER_ERROR);
            $conn = Connection::get();
            if($conn->inTransaction()){
                $conn->rollBack();
            }
            $response->setMessage($ex->getMessage());
            $response->send(false);
        }
        catch (\Exception $ex) {
            $conn = Connection::get();
            if($conn->inTransaction()){
                $conn->rollBack();
            }
            $response->setMessage($ex->getMessage());
            $response->send(false);
        }
    }

    
}