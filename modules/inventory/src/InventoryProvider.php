<?php
namespace Modules\Inventory\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class InventoryProvider extends ServiceProvider
{
    private $namespace = "Modules\Inventory\Controllers";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapApiRoutes();
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
    }

    /**
     * Add api routes in provider using standard 'api' middleware
     *
     * @return void
     */
    private function mapApiRoutes()
    {
        Route::namespace($this->namespace)
            ->middleware("api")
            ->prefix("api")
            ->group(function () {
                require __DIR__. '/../routes.php';
            });
    }
}
