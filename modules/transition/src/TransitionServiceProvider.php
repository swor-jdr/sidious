<?php
namespace Modules\Transition;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TransitionServiceProvider extends ServiceProvider
{
    protected $namespace = "Modules\Transition\Controllers";

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\TransitionPersonnage::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__."/../views", "module::transition");
        $this->loadMigrationsFrom(__DIR__."/../database/migrations");
        $this->mapApiRoutes();
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
                require __DIR__.'/../routes.php';
            });
    }
}
