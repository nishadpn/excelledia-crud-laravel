<?php
    /**
     * Created by PhpStorm.
     * User: NISHAD
     * Date: 19-02-2022
     * Time: 11:36 AM
     */

    namespace Excelledia\Crud;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

    class DBFactory implements FactoryInterface
    {
        protected $table;
        protected $primary='id';

        public function setTable($table){
            $this->table = $table;
            return $this;
        }
        public function setPrimary($primary){
            $this->primary = $primary;
            return $this;
        }

        /**
         * @param $attributes
         */
        public function create($attributes){
            $attributes['created_at'] = Carbon::now();
            $attributes['updated_at'] = Carbon::now();
            try {
                DB::beginTransaction();
                DB::table($this->table)->insert($attributes);
                DB::commit();
            }catch (\Throwable $t){
                DB::rollBack();
            }
        }

        /**
         * @param $id
         */
        public function destroy($id){
                if (is_array($id)){
                    DB::table($this->table)->whereIn($this->primary,$id)->delete();
                } else {
                    DB::table($this->table)->delete($id);
                }

        }
        public function find($id){
            return DB::table($this->table)->find($id);
        }

        public function update($attrs){
            $attributes['updated_at'] = Carbon::now();
            DB::table($this->table)->where($this->primary,$attrs[$this->primary])
                ->update($attrs);
        }
        public function getWithRelation($table,$select, array $relations){
            $dbInstance  = DB::table($table);
            foreach ($relations as  $relation){
                $alias = $relation['alias'] ?: $relation['table'];
                $dbInstance->join($relation['alias']?"{$relation['table']} AS {$relation['table']}":$relation['table'],
                    $relation['foreign_key'],'=',$alias.'.'.$relation['own_key'],$relation['type']);
            }
            if($select){
                $dbInstance->select($select);
            }
            return $dbInstance->get();


        }

        public function dBInterface(callable $closure)
        {
            return $closure(DB::table($this->table));
        }
    }