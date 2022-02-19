<?php
    /**
     * Created by PhpStorm.
     * User: NISHAD
     * Date: 19-02-2022
     * Time: 03:54 PM
     */

    namespace Excelledia\Crud;
    interface FactoryInterface
    {
        public function setTable($table);
        public function setPrimary($primary);
        public function create($attributes);
        public function destroy($id);
        public function find($id);
        public function update($attributes);
        public function dBInterface(callable $closure);
//        public function insertRelationalData($relation,$data);
    }