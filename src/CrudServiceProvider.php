<?php
    /**
     * Created by PhpStorm.
     * User: NISHAD
     * Date: 17-02-2022
     * Time: 09:38 PM
     */
    namespace Excelledia\Crud;
    use Illuminate\Pagination\Paginator;
    use Illuminate\Support\ServiceProvider;
    class CrudServiceProvider extends ServiceProvider
    {
        public function boot(){
            $this->loadViewsFrom(__DIR__.'/resources/views','crud');
            $this->loadRoutesFrom(__DIR__.'/resources/routes/web.php');
            $this->publishes([
                __DIR__.'/config/crud.php'=>config_path('crud.php')
            ],'crud.config');
            $this->publishes([
                __DIR__.'/resources/public'=>public_path('vendor/crud')
            ],'crud.public');
            Paginator::useBootstrap();
        }
        public function register(){

            $this->mergeConfigFrom(__DIR__.'/config/crud.php','crud');
            $this->app->bind(FactoryInterface::class,DBFactory::class);
        }
    }