<?php

namespace app\libs\http;

/**
 * Descripción de Response
 *
 * @author Ing. Jose Rasjido
 */

final class Response{

    private string $message;
    private array $data;
    
    public function __construct(){
        $this->setMessage("");
        $this->setData([]);
    }


    public function setMessage(string $message): void{
        $this->message = $message;
    }

    public function setData(array $result): void{
        $this->data = $result;
    }

    public function send(bool $success = true): void{
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode([
            "success"    => $success,
            "message"    => $this->message,
            "data"       => $this->data
        ]);
    }

    public function sendImage($fullFileName): void{
        if(!file_exists($fullFileName)){
            throw new \Exception("No se pudo encontrar la imagen en el sistema de archivos");
        }
        $mimeType = mime_content_type($fullFileName);
        header("Content-Type: " . $mimeType);
        readfile($fullFileName);
    }

}