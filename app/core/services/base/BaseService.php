<?php

namespace app\core\services\base;

use app\core\models\dao\base\InterfaceDao; 

abstract class BaseService {

    public function __construct(protected InterfaceDao $dao) {
        $this->dao = $dao;
    }
}