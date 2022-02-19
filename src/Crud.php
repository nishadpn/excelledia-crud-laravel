<?php
    /**
     * Created by PhpStorm.
     * User: NISHAD
     * Date: 17-02-2022
     * Time: 10:00 PM
     */

    namespace Excelledia\Crud;

    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;

    class Crud
    {
        protected $bean;
        protected $table;
        protected $relations = [];
        protected $fields = [];
        protected $validation = [
        ];
        protected $dnInstance;
        protected $request;
        protected $dBFactory;
        protected $primary = 'id';
        protected $attrGroups = [];

        public function __construct(Request $request, FactoryInterface $DBFactory)
        {
            $this->request   = $request;
            $this->dBFactory = $DBFactory;
        }

        public function setTable($table): self
        {
            $this->table = $table;
            $this->dBFactory->setTable($table);
//            $this->bean->table($table);
            return $this;
        }

        public function setPrimary($primary): self
        {
            $this->primary = $primary;
            $this->dBFactory->setPrimary($primary);
            return $this;
        }

        public function render()
        {
            switch (strtoupper($this->request->method())) {
                case 'GET':
                    return $this->renderView();
                    break;
                case 'POST':
                    return $this->addEntry();
                    break;
                case 'PATCH':
                    return $this->editEntry();
                    break;
                case 'DELETE':
                    return $this->deleteEntry();
                    break;
            }
        }

        protected function renderView()
        {
            if ($this->request->get('id')) {
                return response()->json($this->dBFactory->find($this->request->get('id')), 200);
            }
            $collection = $this->processPaginate(10);
            $fieldList  = array_keys($this->fields);
            unset($fieldList[$this->primary]);
            return view('crud::content', [
                'collection' => $collection,
                'beanType' => $this->table,
                'fieldList' => $fieldList,
                'fields' => $this->fields,
                'primary' => $this->primary,
            ]);
        }

        protected function addEntry()
        {
            $validator = Validator::make($this->request->all(), $this->getValidation());
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            try {
                DB::beginTransaction();
                $this->dBFactory->create($this->request->all());
                DB::commit();
            } catch (\Throwable $t) {
                DB::rollBack();
            }
            return response()->json([
                'message' => 'Successfully added'
            ], 200);
        }

        protected function editEntry()
        {
            $entry     = $this->dBFactory->find($this->request->{$this->primary});
            $validator = Validator::make($this->request->all(), $this->getValidation('update', $entry));
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            try {
                DB::beginTransaction();
                $this->dBFactory->update($this->request->except(['_method']));
                DB::commit();
            } catch (\Throwable $t) {
                DB::rollBack();
            }
            return response()->json([
                'message' => 'Successfully edited'
            ], 200);
        }

        protected function deleteEntry()
        {
            try {
                DB::beginTransaction();
                $this->dBFactory->destroy($this->request->deletedIds);
                DB::commit();
            } catch (\Throwable $t) {
                DB::rollBack();
            }
            return response()->json([
                'message' => 'Successfully Deleted'
            ], 201);
        }

        public function setFields(array $fields): self
        {
            $this->fields = [];
            $defaultConf  = [
                'required' => false,
            ];
            foreach ($fields as $index => $atributes) {
                if (is_string($atributes)) {
                    $this->fields[$atributes] = $defaultConf;
                } else {
                    $this->fields[$index] = array_merge($defaultConf, $atributes);
                }
            }
            return $this;
        }

        public function setAttributeGroups($attrGroups)
        {
            $this->attrGroups = $attrGroups;
            return $this;
        }

        /**
         * @param string $flag
         * @param array $existingValues
         * @return array
         */
        public function getValidation($flag = 'store', $existingValues = []): array
        {
            $validationArray = [];
            foreach ($this->fields as $field => $attributes) {
                $validation = [];
                if (!empty($attributes['required'])) {
                    $validation[] = 'required';
                }
                if (!empty($attributes['unique'])) {
                    $validation[] = $flag === 'update' ? Rule::unique($this->table)->ignore($existingValues->{$field}, $field) : 'unique:' . $this->table;
//
                }
                if (!empty($attributes['validations'])) {
                    $validation = array_merge($attributes['validations'], $validation);
                }
                $validationArray[$field] = $validation;
            }
            return $validationArray;
        }

        public function setRelation($foreignKey, $table, $ownKey, $type, $alias = ""): self
        {
            $this->relations[$alias ?: $table] = [
                'foreign_key' => $foreignKey,
                'table' => $table,
                'own_key' => $ownKey,
                'type' => $type,
                'alias' => $alias,
            ];
            return $this;
        }

        public function processPaginate($count)
        {
            return $this->dBFactory->dBInterface(function ($instance) use ($count) {
                foreach ($this->relations as $relation) {
                    $alias = $relation['alias'] ?: $relation['table'];
                    $instance->join($relation['alias'] ? "{$relation['table']} AS {$relation['table']}" : $relation['table'],
                        $relation['foreign_key'], '=', $alias . '.' . $relation['own_key'], $relation['type']);
                }
                return $instance->select($this->table . '.' . $this->primary, ...array_keys($this->fields))
                    ->paginate($count);
            });
        }
    }