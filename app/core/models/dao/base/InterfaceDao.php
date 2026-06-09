<?php
    namespace app\core\models\dao\base;

    interface InterfaceDao{
        /*
        * Devuelve un registro especifico desde la base de datos
        * @param int $id identificador del registro
        * @return array Resultados de la busqueda
        */
        public function load(int $id): array;
        /*
        * Guarda un registro especifico en la base de datos
        * @param array $data Conjunto de datos a persistir
        */
        public function save(array $data): void;
        
        /*
        * Actualizar un registro especifico de la base de datos
        * @param array $data Conjunto de datos a persistir
        */
        public function update(array $data): void;

        /*
        * Eliminar un registro de la base de datos.
        * @param int $id identificador del registro
        */
        public function delete(int $id): void;


        /*
        * Carga los registros definidos por un filtro
        * @param array $filters Conjunto de filtros a aplicar en la base de datos
        * @return array Conjunto de datos a mostrar.
        */
        public function list(array $filters): array;

    }
