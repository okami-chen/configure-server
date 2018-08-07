<?php

namespace OkamiChen\ConfigureServer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use OkamiChen\ConfigureServer\Entity\ConfigureGroup;
use OkamiChen\ConfigureServer\Entity\ConfigureNode;
use OkamiChen\ConfigureServer\Observer\NodeObserver;
use OkamiChen\ConfigureServer\Observer\GroupObserver;

class ServerServiceProvider extends ServiceProvider {

    /**
     * @var array
     */
    protected $commands = [

    ];
    
    protected $observers    = [
        ConfigureNode::class    => NodeObserver::class,
        ConfigureGroup::class   => GroupObserver::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path('configure')], 'configure-server');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'configure-server');
        }
        
        $this->registerRouter();
        
        $this->registerObserver();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //$this->commands($this->commands);
    }
    
    /**
     * 注册路由
     */
    protected function registerRouter(){
        
        $attributes = [
            'prefix'     => config('admin.route.prefix'),
            'namespace'  => __NAMESPACE__.'\Controller',
            'middleware' => config('admin.route.middleware'),
        ];

        Route::group($attributes, function (Router $router) {
            $router->resource('/module/confiurge/server/group', 'GroupController',['as'=>'tms']);
            $router->resource('/module/confiurge/server/node', 'NodeController',['as'=>'tms']);
        });
    }
    
    /**
     * 观察者
     */
    protected function registerObserver(){
        
        foreach ($this->observers as $key => $observer) {
            $key::observe($observer);
        }
        
    }

}
