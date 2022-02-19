### Installation Instructions
1. From your projects root folder in terminal run:

    Laravel  use:

    ```
        Download the repository and add to yor laravel project
        
    ```


2. Publish the assets to public:

    ```
        php artisan vendor:publish --tag=crud.public
    ```
### Usage example
 1.initialize like here
 
    ```
    return $this->crud->setTable('test')
                    ->setFields(['field1','field1','field3'=>['required'=>true,'unique'=>true]'])
                    ->render();
    ```
   
  2. Route Define as any
  ```
  Route::any('/',[\Excelledia\Crud\Http\Controllers\CrudController::class,'index'])
  ``` 
   