<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your packkage. These
    | routes are loaded by the PackageServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::group(['prefix' => config('crud.route_prefix'), 'as' => config('crud.route_name_prefix').'.', 'namespace' => 'Excelledia\Crud\Http\Controllers'],function (){
       Route::any('/',[\Excelledia\Crud\Http\Controllers\CrudController::class,'index'])->name('home');
    });
