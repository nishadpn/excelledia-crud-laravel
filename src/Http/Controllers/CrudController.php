<?php
    /**
     * Created by PhpStorm.
     * User: NISHAD
     * Date: 18-02-2022
     * Time: 08:02 PM
     */

    namespace Excelledia\Crud\Http\Controllers;
    use Excelledia\Crud\Crud;
    use Excelledia\Crud\DBFactory;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;

    class CrudController extends Controller
    {
        protected $crud;
        protected $factory;
        public function __construct(Crud $crud)
        {
            $this->crud = $crud;
        }

        public function index(){
            return $this->crud->setTable('customers')
                ->setFields(['first_name','last_name','last_name','email'=>['required'=>true,'unique'=>true],'phone'])
                ->render();
            return view('crud::app-bk');
        }
        public function customers(){
            return $this->crud->setTable('customers')
                ->setFields(['first_name','last_name','last_name','email'=>['required'=>true,'unique'=>true],'phone'])
                ->render();
        }

    }