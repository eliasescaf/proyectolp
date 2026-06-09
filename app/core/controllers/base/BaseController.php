<?php

namespace app\core\controllers\base;

use app\libs\http\Request;

class BaseController{
    protected string $view;
    protected array $scripts;
    protected array $modules;
    protected array $modals;
    protected array $breadcrumb;

    public function __construct($scripts = [], $modules = [], $modals = []){
        $this->view = "";
        $this->scripts = $scripts;
        $this->modules = $modules;
        $this->modals = $modals;
        $this->breadcrumb = [
            "title" => "",
            "icon" => "",
            "nav" => []
        ];
    }

    protected function setCurrentView(Request $request): void{
        $this->view = $request->getController() . '/' . $request->getAction() . '.php';
    }
}